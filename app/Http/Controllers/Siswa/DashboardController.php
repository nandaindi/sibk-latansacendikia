<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Konseling;
use App\Models\Pelanggaran;
use App\Models\User;
use App\Notifications\KonselingPengajuanBaruNotification;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /** Dashboard utama siswa */
    public function index()
    {
        $userId = auth()->id();

        $activeKonselingCount = Konseling::where('user_id', $userId)
            ->whereIn('status', ['pending', 'disetujui', 'dipanggil'])
            ->count();

        $activeKonseling = Konseling::where('user_id', $userId)
            ->whereIn('status', ['pending', 'disetujui', 'dipanggil'])
            ->latest()
            ->first();

        $activePelanggaranCount = Pelanggaran::where('user_id', $userId)
            ->where('status', 'menunggu')
            ->count();

        $activePelanggaran = Pelanggaran::where('user_id', $userId)
            ->where('status', 'menunggu')
            ->latest()
            ->first();

        $activeAlerts = collect();
        if ($activeKonseling) {
            $activeKonseling->alert_type = 'konseling';
            $activeAlerts->push($activeKonseling);
        }
        if ($activePelanggaran) {
            $activePelanggaran->alert_type = 'pelanggaran';
            $activeAlerts->push($activePelanggaran);
        }
        $activeAlerts = $activeAlerts->sortByDesc('updated_at');

        $articles = Artikel::with('penulis')->latest()->take(4)->get();

        return view('siswa.dashboard', compact(
            'activeAlerts',
            'activeKonselingCount',
            'activePelanggaranCount',
            'articles'
        ));
    }


    /** List panggilan/pelanggaran (dipanggil oleh BK) */
    public function panggilan()
    {
        $panggilan = Pelanggaran::where('user_id', auth()->id())
            ->whereIn('status', ['menunggu', 'diterima'])
            ->latest()
            ->get();

        return view('siswa.panggilan', compact('panggilan'));
    }

    /** Detail Panggil Siswa */
    public function detailPanggilan($id)
    {
        $panggilan = Pelanggaran::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        return view('siswa.detail-panggilan', compact('panggilan'));
    }

    /** Terima panggilan dari BK (sekarang hanyalah konfirmasi hadir / membaca) */
    public function terimaPanggilan(Request $request)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggarans,id',
        ]);

        $pelanggaran = \App\Models\Pelanggaran::where('id', $request->pelanggaran_id)
            ->where('user_id', auth()->id())
            ->first();

        if (! $pelanggaran) {
            abort(404);
        }

        try {
            $pelanggaran->update([
                'status' => 'diterima',
                'is_read' => true,
            ]);
        } catch (\Throwable $e) {
            report($e);

            return redirect()->back()->with('error', 'Gagal memproses konfirmasi panggilan. Silakan coba lagi.');
        }

        return redirect()->route('siswa.dashboard')->with('sukses', 'Terima kasih, silakan temui Guru BK sesuai jadwal panggilan.');
    }

    /** Pengajuan Online */
    public function pengajuanOnline()
    {
        return view('siswa.form-pengajuan-online');
    }

    public function storePengajuanOnline(Request $request)
    {
        $request->validate([
            'jadwal' => 'required|date',
            'problem_type' => 'required|string|max:100',
            'note' => 'nullable|string|max:2000',
        ]);

        $activeKonseling = Konseling::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'disetujui', 'dipanggil'])
            ->first();

        if ($activeKonseling) {
            return redirect()->route('siswa.dashboard')
                ->with('warning_pengajuan', 'Kamu sudah punya pengajuan konseling yang sedang aktif. Harap tunggu sampai selesai.');
        }

        $tanggal = now()->format('Y-m-d');
        $waktu = now()->format('H:i');
        if ($request->jadwal) {
            $dt = Carbon::parse($request->jadwal);
            if ($dt->isPast()) {
                return back()->with('error', 'Gagal! Waktu pengajuan tidak boleh di masa lalu.');
            }
            $tanggal = $dt->format('Y-m-d');
            $waktu = $dt->format('H:i');
        }

        $konseling = DB::transaction(function () use ($request, $tanggal, $waktu) {
            \App\Models\User::whereKey(auth()->id())->lockForUpdate()->firstOrFail();
            if (Konseling::where('user_id', auth()->id())->whereIn('status', ['pending', 'disetujui', 'dipanggil'])->exists()) {
                throw ValidationException::withMessages(['jadwal' => 'Kamu sudah memiliki pengajuan konseling aktif.']);
            }
            return Konseling::create(['user_id' => auth()->id(), 'jenis' => 'online', 'problem_type' => $request->problem_type, 'tanggal' => $tanggal, 'waktu' => $waktu, 'status' => 'pending', 'catatan_siswa' => $request->note]);
        });

        $this->kirimNotifikasiPengajuanBaru($konseling);

        return redirect()->route('siswa.pengajuan-proses')->with('pengajuan_sukses', true);
    }

    /** Pengajuan Offline */
    public function pengajuanOffline()
    {
        return view('siswa.form-pengajuan-offline');
    }

    public function storePengajuanOffline(Request $request)
    {
        $request->validate([
            'jadwal' => 'required|date',
            'problem_type' => 'required|string|max:100',
            'note' => 'nullable|string|max:2000',
        ]);

        $activeKonseling = Konseling::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'disetujui', 'dipanggil'])
            ->first();

        if ($activeKonseling) {
            return redirect()->route('siswa.dashboard')
                ->with('warning_pengajuan', 'Kamu sudah punya pengajuan konseling yang sedang aktif. Harap tunggu sampai selesai.');
        }

        $tanggal = now()->format('Y-m-d');
        $waktu = now()->format('H:i');
        if ($request->jadwal) {
            $dt = Carbon::parse($request->jadwal);
            // ponytail: tolak jika waktu sudah lewat
            if ($dt->isPast()) {
                return back()->with('error', 'Gagal! Waktu pengajuan tidak boleh di masa lalu.');
            }
            $tanggal = $dt->format('Y-m-d');
            $waktu = $dt->format('H:i');
        }

        $konseling = DB::transaction(function () use ($request, $tanggal, $waktu) {
            \App\Models\User::whereKey(auth()->id())->lockForUpdate()->firstOrFail();
            if (Konseling::where('user_id', auth()->id())->whereIn('status', ['pending', 'disetujui', 'dipanggil'])->exists()) {
                throw ValidationException::withMessages(['jadwal' => 'Kamu sudah memiliki pengajuan konseling aktif.']);
            }
            return Konseling::create(['user_id' => auth()->id(), 'jenis' => 'offline', 'problem_type' => $request->problem_type, 'tanggal' => $tanggal, 'waktu' => $waktu, 'status' => 'pending', 'catatan_siswa' => $request->note]);
        });

        $this->kirimNotifikasiPengajuanBaru($konseling);

        return redirect()->route('siswa.pengajuan-proses')->with('pengajuan_sukses', true);
    }

    /** Pengajuan Sedang Diproses */
    public function pengajuanProses()
    {
        $konseling = Konseling::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'disetujui', 'dipanggil', 'ditolak'])
            ->latest()
            ->first();

        if ($konseling && $konseling->status === 'disetujui') {
            return $konseling->jenis === 'online'
                ? redirect()->route('siswa.mulai-konseling')
                : redirect()->route('siswa.konseling-offline');
        }

        if ($konseling && $konseling->status === 'ditolak') {
            return redirect()->route('siswa.pengajuan-ditolak');
        }

        return view('siswa.pengajuan-proses');
    }

    /** Pengajuan Ditolak - tampilkan alasan */
    public function pengajuanDitolak()
    {
        $tolak = Konseling::where('user_id', auth()->id())
            ->where('status', 'ditolak')
            ->latest()
            ->first();

        return view('siswa.pengajuan-ditolak', compact('tolak'));
    }

    /** Detail Laporan (Selesai) */
    public function detailLaporan($id)
    {
        $laporan = Konseling::where('user_id', auth()->id())
            ->where('id', $id)
            ->where('status', 'selesai')
            ->firstOrFail();

        if (! $laporan->is_read) {
            $laporan->is_read = true;
            $laporan->save();
        }

        return view('siswa.detail-laporan', compact('laporan'));
    }

    /** Mulai Konseling Online */
    public function mulaiKonseling()
    {
        $konseling = Konseling::where('user_id', auth()->id())
            ->where('status', 'disetujui')
            ->where('jenis', 'online')
            ->latest()->first();

        // Auto-expire: jika jadwal sudah lewat lebih dari 2 jam
        if ($konseling) {
            $jadwal = \Carbon\Carbon::parse($konseling->tanggal . ' ' . ($konseling->waktu ?? '23:59'));
            if (now()->greaterThan($jadwal->addHours(2))) {
                $konseling->update(['status' => 'tidak_hadir']);
                $konseling = null;
            }
        }

        if (! $konseling) {
            return redirect()->route('siswa.dashboard')
                ->with('warning', 'Tidak ada sesi konseling online yang aktif saat ini.');
        }

        return view('siswa.mulai-konseling', compact('konseling'));
    }

    /** Konseling Offline - tampilan jadwal offline yang disetujui */
    public function konselingOffline()
    {
        $konseling = Konseling::where('user_id', auth()->id())
            ->where('status', 'disetujui')
            ->where('jenis', 'offline')
            ->latest()->first();

        // Auto-expire: jika jadwal sudah lewat lebih dari 2 jam, tandai tidak_hadir
        if ($konseling) {
            $jadwal = \Carbon\Carbon::parse($konseling->tanggal . ' ' . ($konseling->waktu ?? '23:59'));
            if (now()->greaterThan($jadwal->addHours(2))) {
                $konseling->update(['status' => 'tidak_hadir']);
                $konseling = null;
            }
        }

        if (! $konseling) {
            return redirect()->route('siswa.dashboard')
                ->with('warning', 'Tidak ada sesi konseling offline yang aktif saat ini.');
        }

        return view('siswa.konseling-offline', compact('konseling'));
    }

    /** Chat Konseling - saat konseling berlangsung atau baru selesai meminta feedback */
    public function chatKonseling()
    {
        $userId = auth()->id();

        $konseling = Konseling::where('user_id', $userId)
            ->where(function ($q) {
                $q->where('status', 'disetujui')
                    ->orWhere(function ($sq) {
                        $sq->where('status', 'selesai')
                            ->whereNull('kesimpulan_siswa');
                    });
            })
            ->where('jenis', 'online')
            ->latest()->first();

        return view('siswa.chat-konseling', compact('konseling'));
    }

    /** Simpan feedback siswa (kesimpulan & saran) */
    public function storeFeedback(Request $request)
    {
        $request->validate([
            'konseling_id' => 'required|exists:konselings,id',
            'kesimpulan_siswa' => 'required|string',
            'saran_siswa' => 'required|string',
            'kepuasan_penerimaan' => 'nullable|string',
            'kepuasan_kemudahan' => 'nullable|string',
            'kepuasan_kepercayaan' => 'nullable|string',
            'kepuasan_pelayanan' => 'nullable|string',
        ]);

        $konseling = Konseling::where('user_id', auth()->id())
            ->where('status', 'selesai')
            ->whereNull('kesimpulan_siswa')
            ->findOrFail($request->konseling_id);

        $konseling->update([
            'kesimpulan_siswa' => $request->kesimpulan_siswa,
            'saran_siswa' => $request->saran_siswa,
            'kepuasan_penerimaan' => $request->kepuasan_penerimaan,
            'kepuasan_kemudahan' => $request->kepuasan_kemudahan,
            'kepuasan_kepercayaan' => $request->kepuasan_kepercayaan,
            'kepuasan_pelayanan' => $request->kepuasan_pelayanan,
        ]);

        return redirect()->route('siswa.dashboard')->with('sukses', 'Terima kasih atas kesimpulan dan saran yang telah kamu berikan.');
    }

    /** Riwayat Konseling - semua historis laporan (selesai) */
    public function riwayatKonseling()
    {
        $riwayats = Konseling::where('user_id', auth()->id())
            ->where('status', 'selesai')
            ->latest()
            ->paginate(10);

        return view('siswa.riwayat-konseling', compact('riwayats'));
    }

    /** Membaca Artikel Edukasi */
    public function bacaArtikel($slug)
    {
        $artikel = Artikel::with('penulis')->where('slug', $slug)->firstOrFail();

        return view('siswa.artikel-detail', compact('artikel'));
    }

    /** Daftar Semua Artikel Edukasi */
    public function indexArtikel()
    {
        $articles = Artikel::with('penulis')->latest()->paginate(12);

        return view('siswa.artikel-index', compact('articles'));
    }

    /** Tandai semua notifikasi sebagai sudah dibaca */
    public function markNotificationsAsRead()
    {
        $user = auth()->user();

        $user->unreadNotifications->markAsRead();

        Konseling::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        Pelanggaran::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('sukses', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /** Halaman Pusat Notifikasi (Gabungan semua aktivitas) */
    public function allNotifications()
    {
        $userId = auth()->id();

        $konselingNotifs = Konseling::with('bk')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $pelanggaranNotifs = Pelanggaran::with('bk')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $mergedNotifications = $konselingNotifs->concat($pelanggaranNotifs)
            ->sortByDesc(function ($item) {
                return $item->updated_at ?? $item->created_at;
            });

        $perPage = 15;
        $page = request()->get('page', 1);
        $notifications = new LengthAwarePaginator(
            $mergedNotifications->forPage($page, $perPage),
            $mergedNotifications->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('siswa.notifications-index', compact('notifications'));
    }

    private function kirimNotifikasiPengajuanBaru(Konseling $konseling): void
    {
        Notification::send(
            User::role('bk')->get(),
            new KonselingPengajuanBaruNotification($konseling->loadMissing('user'))
        );
    }
}
