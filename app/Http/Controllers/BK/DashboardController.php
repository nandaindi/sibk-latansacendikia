<?php

namespace App\Http\Controllers\BK;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Konseling;
use App\Models\Laporan;
use App\Models\Pelanggaran;
use App\Models\User;
use App\Notifications\KonselingStatusNotification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /** Dashboard utama BK */
    public function index()
    {
        $bkId = auth()->id();
        $today = now()->format('Y-m-d');

        $pendingCount = Konseling::where('status', 'pending')->count();

        $konselingHariIni = Konseling::with('user')
            ->where('status', 'disetujui')
            ->where('bk_id', $bkId)
            ->whereDate('tanggal', $today)
            ->get()
            ->each(function ($item) {
                $item->entry_type = 'konseling';
            });

        $panggilanHariIni = Pelanggaran::with('user')
            ->where('status', 'menunggu')
            ->where('bk_id', $bkId)
            ->whereDate('tanggal', $today)
            ->get()
            ->each(function ($item) {
                $item->entry_type = 'pelanggaran';
            });

        $jadwalHariIni = $konselingHariIni->concat($panggilanHariIni)->sortBy('waktu');

        $pendingRequests = Konseling::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $sesiAktifCount = Konseling::where('status', 'disetujui')
            ->where('bk_id', $bkId)
            ->count();

        $panggilanCount = Pelanggaran::where('status', 'menunggu')
            ->where('bk_id', $bkId)
            ->count();

        $articles = Artikel::with('penulis')->latest()->take(4)->get();

        return view('bk.dashboard', compact(
            'pendingCount', 'jadwalHariIni', 'pendingRequests', 'articles', 'sesiAktifCount', 'panggilanCount'
        ));
    }

    /** Panggil Siswa - form & list */
    public function panggilSiswa()
    {
        $siswas = User::role('siswa')->orderBy('name')->get();

        $riwayatPanggilan = Konseling::with('user')
            ->where('bk_id', auth()->id())
            ->whereIn('status', ['dipanggil', 'selesai', 'tidak_hadir'])
            ->where('jenis', 'offline')
            ->latest()
            ->take(10)
            ->get();

        return view('bk.panggil-siswa', compact('siswas', 'riwayatPanggilan'));
    }

    /** Store panggilan siswa — buat record konseling ber-status 'dipanggil' */
    public function storePanggilSiswa(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'topik'   => 'required|string|max:200',
            'tanggal' => 'required|date',
            'waktu'   => 'required',
            'catatan' => 'nullable|string|max:1000',
        ]);

        if (\Carbon\Carbon::parse($request->tanggal . ' ' . $request->waktu)->isPast()) {
            return back()->with('error', 'Gagal! Waktu penjadwalan sudah lewat.');
        }

        if (Konseling::cekBentrok($request->tanggal, $request->waktu, auth()->id(), $request->user_id)) {
            return back()->with('error', 'Gagal! Anda atau Siswa tersebut sudah memiliki jadwal konseling di jam itu.');
        }

        $catatanLengkap = 'Topik: '.$request->topik."\n\nCatatan: ".($request->catatan ?? '-');

        Konseling::create([
            'user_id'    => $request->user_id,
            'bk_id'      => auth()->id(),
            'jenis'      => 'offline',
            'tanggal'    => $request->tanggal,
            'waktu'      => $request->waktu,
            'status'     => 'dipanggil',
            'catatan_bk' => $catatanLengkap,
        ]);

        return redirect()->route('bk.panggil-siswa')->with('sukses', 'Siswa berhasil dipanggil!');
    }

    /** Daftar Pengajuan Konseling (pending) */
    public function daftarPengajuan()
    {
        $pengajuans = Konseling::with('user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('bk.daftar-pengajuan', compact('pengajuans'));
    }

    /** Validasi Pengajuan - detail pengajuan + tombol setujui/tolak */
    public function validasiPengajuan(Request $request)
    {
        $konseling = Konseling::with('user')->where('status', 'pending')->findOrFail($request->id);

        return view('bk.validasi-pengajuan', compact('konseling'));
    }

    /** Setujui Pengajuan - form input jadwal */
    public function setujuiPengajuan(Request $request)
    {
        $konseling = Konseling::with('user')->where('status', 'pending')->findOrFail($request->id);

        return view('bk.setujui-pengajuan', compact('konseling'));
    }

    /** Store setujui pengajuan - update status + jadwal */
    public function storeSetujuiPengajuan(Request $request)
    {
        $request->validate([
            'konseling_id' => 'required|exists:konselings,id',
            'tanggal'      => 'required|date',
            'waktu'        => 'required',
            'link_meet'    => 'nullable|url',
        ]);

        if (\Carbon\Carbon::parse($request->tanggal . ' ' . $request->waktu)->isPast()) {
            return back()->with('error', 'Gagal! Waktu persetujuan tidak boleh di masa lalu.');
        }

        $konseling = Konseling::where('status', 'pending')->findOrFail($request->konseling_id);

        if (Konseling::cekBentrok($request->tanggal, $request->waktu, auth()->id(), $konseling->user_id, $konseling->id)) {
            return back()->with('error', 'Gagal! Anda atau Siswa tersebut sudah memiliki jadwal konseling lain di jam itu.');
        }

        $konseling->update([
            'status'    => 'disetujui',
            'bk_id'     => auth()->id(),
            'tanggal'   => $request->tanggal,
            'waktu'     => $request->waktu,
            'link_meet' => $request->link_meet,
        ]);

        if ($konseling->user) {
            $konseling->user->notify(new KonselingStatusNotification($konseling, 'disetujui'));
        }

        return redirect()->route('bk.sesi-konseling')->with('sukses', 'Pengajuan berhasil disetujui!');
    }

    /** Setujui Langsung - Gunakan jadwal siswa tanpa pindah halaman */
    public function setujuiLangsung($id)
    {
        $konseling = Konseling::where('status', 'pending')->findOrFail($id);

        if (\Carbon\Carbon::parse($konseling->tanggal . ' ' . $konseling->waktu)->isPast()) {
            return back()->with('error', 'Gagal! Jadwal usulan siswa sudah lewat, silakan setujui dengan jadwal baru.');
        }

        if (Konseling::cekBentrok($konseling->tanggal, $konseling->waktu, auth()->id(), $konseling->user_id, $konseling->id)) {
            return back()->with('error', 'Gagal! Anda atau Siswa tersebut sudah memiliki jadwal konseling lain di jam itu.');
        }

        $konseling->update([
            'status' => 'disetujui',
            'bk_id'  => auth()->id(),
        ]);

        if ($konseling->user) {
            $konseling->user->notify(new KonselingStatusNotification($konseling, 'disetujui'));
        }

        return redirect()->route('bk.sesi-konseling')->with('sukses', 'Pengajuan berhasil disetujui sesuai jadwal siswa!');
    }

    /** Tolak Pengajuan - update status + simpan alasan */
    public function tolakPengajuan(Request $request)
    {
        $request->validate([
            'konseling_id' => 'required|exists:konselings,id',
            'alasan_tolak' => 'required|string|max:1000',
        ]);

        $konseling = Konseling::where('status', 'pending')->findOrFail($request->konseling_id);
        $konseling->update([
            'status'       => 'ditolak',
            'bk_id'        => auth()->id(),
            'alasan_tolak' => $request->alasan_tolak,
        ]);

        if ($konseling->user) {
            $konseling->user->notify(new KonselingStatusNotification($konseling, 'ditolak'));
        }

        return redirect()->route('bk.daftar-pengajuan')->with('sukses', 'Pengajuan berhasil ditolak.');
    }

    /** Sesi Konseling - daftar sesi yang sudah disetujui */
    public function sesiKonseling()
    {
        $sesis = Konseling::with('user')
            ->where('status', 'disetujui')
            ->where('bk_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('bk.sesi-konseling', compact('sesis'));
    }

    /** Detail Sesi Konseling */
    public function detailSesi(Request $request)
    {
        $konseling = Konseling::with('user')->where('bk_id', auth()->id())->where('status', 'disetujui')->findOrFail($request->id);

        return view('bk.detail-sesi', compact('konseling'));
    }

    /** Konseling Online - halaman chat BK */
    public function konselingOnline(Request $request)
    {
        $konseling = Konseling::with('user')->where('bk_id', auth()->id())->where('status', 'disetujui')->findOrFail($request->id);

        if (! $konseling->started_at) {
            $konseling->update(['started_at' => now()]);
        }

        return view('bk.konseling-online', compact('konseling'));
    }

    /** Form Konseling Offline - pencatatan hasil sesi offline */
    public function formKonselingOffline($id)
    {
        $konseling = Konseling::with('user')->where('bk_id', auth()->id())->where('status', 'disetujui')->findOrFail($id);

        if (! $konseling->started_at) {
            $konseling->update(['started_at' => now()]);
        }

        return view('bk.form-konseling-offline', compact('konseling'));
    }

    /** Mulai Sesi Offline - eksplisit klik mulai */
    public function mulaiSesiOffline($id)
    {
        $konseling = Konseling::where('bk_id', auth()->id())->where('status', 'disetujui')->findOrFail($id);
        if (! $konseling->started_at) {
            $konseling->update(['started_at' => now()]);
        }

        return redirect()->route('bk.form-konseling-offline', $id);
    }

    /** Tandai Tidak Hadir - Siswa tidak datang ke sesi offline */
    public function tidakHadirOffline($id)
    {
        $konseling = Konseling::where('bk_id', auth()->id())->where('status', 'disetujui')->findOrFail($id);
        $konseling->update(['status' => 'tidak_hadir']);

        return redirect()->route('bk.sesi-konseling')->with('sukses', 'Siswa ditandai tidak hadir.');
    }

    /** Store form konseling offline – simpan catatan & selesaikan sesi */
    public function storeFormKonselingOffline(Request $request)
    {
        $konseling = $this->validateAndGetKonseling($request);

        $konseling->update([
            'status'     => 'selesai',
            'durasi'     => $this->hitungDurasi($konseling),
            'catatan_bk' => $this->formatCatatan($request),
        ]);

        $this->buatLaporan($konseling);
        $this->buatPertemuanLanjutan($request, $konseling);

        return redirect()->route('bk.laporan-konseling')->with('sukses', 'Sesi selesai, laporan berhasil dibuat!');
    }

    /** Form Konseling Online - pencatatan hasil sesi online */
    public function formKonselingOnline($id)
    {
        $konseling = Konseling::with('user')->findOrFail($id);

        return view('bk.form-konseling-online', compact('konseling'));
    }

    /** Store form konseling online – simpan catatan & buat laporan */
    public function storeFormKonselingOnline(Request $request)
    {
        $konseling = $this->validateAndGetKonseling($request);

        $konseling->update([
            'durasi'     => $this->hitungDurasi($konseling),
            'catatan_bk' => $this->formatCatatan($request),
        ]);

        $this->buatLaporan($konseling);
        $this->buatPertemuanLanjutan($request, $konseling);

        return redirect()->route('bk.laporan-konseling')->with('sukses', 'Hasil konseling online berhasil dicatat dan laporan dibuat!');
    }

    /** Laporan Konseling - list laporan dari sesi selesai */
    public function laporanKonseling(Request $request)
    {
        $jenis = $request->query('jenis');

        $query = Laporan::with(['author', 'user', 'konseling'])
            ->where('author_id', auth()->id());

        if ($jenis && in_array($jenis, ['online', 'offline'])) {
            $query->whereHas('konseling', function ($q) use ($jenis) {
                $q->where('jenis', $jenis);
            });
        }

        $laporans = $query->latest()->paginate(10);

        return view('bk.laporan-konseling', compact('laporans', 'jenis'));
    }

    /** Detail Laporan (BK) */
    public function detailLaporan(Request $request)
    {
        $id = $request->query('id');
        $laporan = Laporan::with(['author', 'konseling.user'])->where('author_id', auth()->id())->findOrFail($id);

        $items = collect();

        if ($laporan->konseling_id && $laporan->konseling) {
            $items = collect([$laporan->konseling]);
        } else {
            $items = Konseling::with('user')->where('status', 'selesai')->latest()->get();
        }

        return view('bk.detail-laporan', compact('laporan', 'items'));
    }

    // ─── Private Helpers ──────────────────────────────────────────────────────

    private function validateAndGetKonseling(Request $request): Konseling
    {
        $request->validate([
            'konseling_id'    => 'required|exists:konselings,id',
            'problem'         => 'required|string',
            'solution'        => 'required|string',
            'note'            => 'nullable|string',
            'has_next_meeting' => 'nullable',
            'next_tanggal'    => 'nullable|required_with:has_next_meeting|date',
            'next_waktu'      => 'nullable|required_with:has_next_meeting',
        ]);

        return Konseling::where('bk_id', auth()->id())
            ->whereIn('status', ['disetujui', 'selesai'])
            ->findOrFail($request->konseling_id);
    }

    private function formatCatatan(Request $request): string
    {
        $catatan = "Problem:\n".$request->problem."\n\nSolution:\n".$request->solution;
        if ($request->note) {
            $catatan .= "\n\nNote:\n".$request->note;
        }

        return $catatan;
    }

    private function hitungDurasi(Konseling $konseling): int
    {
        return $konseling->started_at
            ? max(1, now()->diffInMinutes($konseling->started_at))
            : 1;
    }

    private function buatLaporan(Konseling $konseling): void
    {
        Laporan::firstOrCreate(['konseling_id' => $konseling->id], [
            'nama_laporan' => 'Laporan Konseling: '.$konseling->user->name,
            'author_id'    => auth()->id(),
            'user_id'      => $konseling->user_id,
            'konseling_id' => $konseling->id,
            'tanggal'      => now()->format('Y-m-d'),
            'search_key'   => now()->format('l, d F Y'),
        ]);
    }

    private function buatPertemuanLanjutan(Request $request, Konseling $konseling): void
    {
        if ($request->has('has_next_meeting') && $request->next_tanggal && $request->next_waktu) {
            Konseling::create([
                'user_id'    => $konseling->user_id,
                'bk_id'      => auth()->id(),
                'jenis'      => 'offline',
                'tanggal'    => $request->next_tanggal,
                'waktu'      => $request->next_waktu,
                'status'     => 'dipanggil',
                'catatan_bk' => 'Topik: Tindak Lanjut Sesi Sebelumnya',
            ]);
        }
    }
}
