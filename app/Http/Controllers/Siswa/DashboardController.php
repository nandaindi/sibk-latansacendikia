<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /** Dashboard utama siswa */
    public function index()
    {
        $userId = auth()->id();

        // Auto-expire: tandai sesi 'disetujui' yang sudah lewat jadwal + 2 jam sebagai 'tidak_hadir'
        // Tetapi jangan langsung dimatikan jika statusnya baru saja diubah (updated_at < 2 hours ago)
        \App\Models\Konseling::where('user_id', $userId)
            ->where('status', 'disetujui')
            ->get()
            ->each(function ($sesi) {
                $waktu   = $sesi->waktu ?? '23:59';
                $jadwal  = \Carbon\Carbon::parse($sesi->tanggal . ' ' . $waktu)->addHours(2);
                
                // Jika jadwal terlewat dan session belum diupdate dalam 2 jam terakhir (mencegah bug jam 00:00)
                if (now()->greaterThan($jadwal) && now()->diffInHours($sesi->updated_at) >= 2) {
                    $sesi->update(['status' => 'tidak_hadir']);
                }
            });

        // Cari konseling aktif / pending (exclude tidak_hadir & selesai & ditolak)
        $activeKonseling = \App\Models\Konseling::where('user_id', $userId)
            ->whereIn('status', ['pending', 'disetujui'])
            ->latest()
            ->first();

        $articles = \App\Models\Artikel::with('penulis')->latest()->take(4)->get();

        return view('siswa.dashboard', compact('activeKonseling', 'articles'));
    }

    /** List panggilan/pelanggaran (dipanggil oleh BK) */
    public function panggilan()
    {
        $panggilan = \App\Models\Pelanggaran::where('user_id', auth()->id())
            ->where('status', 'menunggu')
            ->latest()
            ->get();
        return view('siswa.panggilan', compact('panggilan'));
    }

    /** Detail panggilan pelanggaran */
    public function detailPanggilan($id)
    {
        $panggilan = \App\Models\Pelanggaran::where('user_id', auth()->id())
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

        // Dalam flow baru, siswa cuma melihat detail atau tombol "Mengerti"
        // Jika perlu status dibaca, bisa ditambahkan di migration nanti.
        // Untuk sekarang redirect ke dashboard.
        
        return redirect()->route('siswa.dashboard')->with('sukses', 'Silakan temui Guru BK sesuai jadwal panggilan.');
    }

    /** Pengajuan Online */
    public function pengajuanOnline()
    {
        return view('siswa.form-pengajuan-online');
    }

    public function storePengajuanOnline(Request $request)
    {
        // Cek apakah sudah ada pengajuan aktif
        $activeKonseling = \App\Models\Konseling::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'disetujui'])
            ->first();

        if ($activeKonseling) {
            return redirect()->route('siswa.dashboard')
                ->with('warning_pengajuan', 'Kamu sudah punya pengajuan konseling yang sedang aktif. Harap tunggu sampai selesai.');
        }

        \App\Models\Konseling::create([
            'user_id' => auth()->id(),
            'jenis' => 'online',
            'problem_type' => $request->problem_type,
            'tanggal' => now()->format('Y-m-d'),
            'status' => 'pending'
        ]);
        return redirect()->route('siswa.pengajuan-proses')->with('pengajuan_sukses', true);
    }

    /** Pengajuan Offline */
    public function pengajuanOffline()
    {
        return view('siswa.form-pengajuan-offline');
    }

    public function storePengajuanOffline(Request $request)
    {
        // Cek apakah sudah ada pengajuan aktif
        $activeKonseling = \App\Models\Konseling::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'disetujui'])
            ->first();

        if ($activeKonseling) {
            return redirect()->route('siswa.dashboard')
                ->with('warning_pengajuan', 'Kamu sudah punya pengajuan konseling yang sedang aktif. Harap tunggu sampai selesai.');
        }

        \App\Models\Konseling::create([
            'user_id' => auth()->id(),
            'jenis' => 'offline',
            'problem_type' => $request->problem_type,
            'tanggal' => now()->format('Y-m-d'),
            'status' => 'pending'
        ]);
        return redirect()->route('siswa.pengajuan-proses')->with('pengajuan_sukses', true);
    }


    /** Pengajuan Sedang Diproses */
    public function pengajuanProses()
    {
        return view('siswa.pengajuan-proses');
    }

    /** Pengajuan Ditolak - tampilkan alasan */
    public function pengajuanDitolak()
    {
        $tolak = \App\Models\Konseling::where('user_id', auth()->id())
            ->where('status', 'ditolak')
            ->latest()
            ->first();
        return view('siswa.pengajuan-ditolak', compact('tolak'));
    }

    /** Detail Laporan (Selesai) */
    public function detailLaporan($id)
    {
        $laporan = \App\Models\Konseling::where('user_id', auth()->id())
            ->where('id', $id)
            ->where('status', 'selesai')
            ->firstOrFail();

        // Tandai sudah dibaca begitu siswa membuka laporan ini
        if (!$laporan->is_read) {
            $laporan->is_read = true;
            $laporan->save();
        }

        return view('siswa.detail-laporan', compact('laporan'));
    }

    /** Mulai Konseling Online */
    public function mulaiKonseling()
    {
        $konseling = \App\Models\Konseling::where('user_id', auth()->id())
            ->where('status', 'disetujui')
            ->where('jenis', 'online')
            ->latest()->first();
        return view('siswa.mulai-konseling', compact('konseling'));
    }

    /** Konseling Offline - tampilan jadwal offline yang disetujui */
    public function konselingOffline()
    {
        $konseling = \App\Models\Konseling::where('user_id', auth()->id())
            ->where('status', 'disetujui')
            ->where('jenis', 'offline')
            ->latest()->first();
        return view('siswa.konseling-offline', compact('konseling'));
    }

    /** Chat Konseling - saat konseling berlangsung atau baru selesai meminta feedback */
    public function chatKonseling()
    {
        $userId = auth()->id();
        
        // Cari konseling aktif (disetujui) OR konseling selesai tapi belum ada feedback (kesimpulan_siswa)
        $konseling = \App\Models\Konseling::where('user_id', $userId)
            ->where(function($q) {
                $q->where('status', 'disetujui')
                  ->orWhere(function($sq) {
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
            'saran_siswa'      => 'required|string',
        ]);

        $konseling = \App\Models\Konseling::where('user_id', auth()->id())
            ->findOrFail($request->konseling_id);

        $konseling->update([
            'kesimpulan_siswa' => $request->kesimpulan_siswa,
            'saran_siswa'      => $request->saran_siswa,
        ]);

        return redirect()->route('siswa.dashboard')->with('sukses', 'Terima kasih atas kesimpulan dan saran yang telah kamu berikan.');
    }

    /** Riwayat Konseling - semua historis laporan (selesai) */
    public function riwayatKonseling()
    {
        $riwayats = \App\Models\Konseling::where('user_id', auth()->id())
            ->where('status', 'selesai')
            ->latest()
            ->paginate(10);
        return view('siswa.riwayat-konseling', compact('riwayats'));
    }

    /** Membaca Artikel Edukasi */
    public function bacaArtikel($slug)
    {
        $artikel = \App\Models\Artikel::with('penulis')->where('slug', $slug)->firstOrFail();
        return view('siswa.artikel-detail', compact('artikel'));
    }

    /** Daftar Semua Artikel Edukasi */
    public function indexArtikel()
    {
        $articles = \App\Models\Artikel::with('penulis')->latest()->paginate(12);
        return view('siswa.artikel-index', compact('articles'));
    }
}
