<?php

namespace App\Http\Controllers\BK;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /** Dashboard utama BK */
    public function index()
    {
        $bkId = auth()->id();
        $today = now()->format('Y-m-d');

        // Quick Stats
        $pendingCount = Konseling::where('status', 'pending')->count();

        // Jadwal Hari Ini
        $jadwalHariIni = Konseling::with('user')
            ->where('status', 'disetujui')
            ->where('bk_id', $bkId)
            ->whereDate('tanggal', $today)
            ->orderBy('waktu', 'asc')
            ->get();

        // Pengajuan Pending Terbaru
        $pendingRequests = Konseling::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Artikel Edukasi
        $articles = \App\Models\Artikel::with('penulis')->latest()->take(4)->get();

        return view('bk.dashboard', compact(
            'pendingCount', 'jadwalHariIni', 'pendingRequests', 'articles'
        ));
    }

    /** Panggil Siswa - form & list */
    public function panggilSiswa()
    {
        $siswas = User::where('role', 'siswa')->orderBy('name')->get();
        // Ambil riwayat panggilan (status dipanggil atau selesai) khusus BK ini
        $riwayatPanggilan = Konseling::with('user')
            ->where('bk_id', auth()->id())
            ->whereIn('status', ['dipanggil', 'selesai', 'tidak_hadir'])
            ->where('jenis', 'offline') // Karena Panggil Siswa itu offline
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

        $catatanLengkap = "Topik: " . $request->topik . "\n\nCatatan: " . ($request->catatan ?? '-');

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
        $konseling = Konseling::with('user')->findOrFail($request->id);
        return view('bk.validasi-pengajuan', compact('konseling'));
    }

    /** Setujui Pengajuan - form input jadwal */
    public function setujuiPengajuan(Request $request)
    {
        $konseling = Konseling::with('user')->findOrFail($request->id);
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

        $konseling = Konseling::findOrFail($request->konseling_id);
        $konseling->update([
            'status'   => 'disetujui',
            'bk_id'    => auth()->id(),
            'tanggal'  => $request->tanggal,
            'waktu'    => $request->waktu,
            'link_meet'=> $request->link_meet,
        ]);

        return redirect()->route('bk.sesi-konseling')->with('sukses', 'Pengajuan berhasil disetujui!');
    }

    /** Tolak Pengajuan - update status + simpan alasan */
    public function tolakPengajuan(Request $request)
    {
        $request->validate([
            'konseling_id' => 'required|exists:konselings,id',
            'alasan_tolak' => 'required|string|max:1000',
        ]);

        $konseling = Konseling::findOrFail($request->konseling_id);
        $konseling->update([
            'status'       => 'ditolak',
            'bk_id'        => auth()->id(),
            'alasan_tolak' => $request->alasan_tolak,
        ]);

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
        $konseling = Konseling::with('user')->findOrFail($request->id);
        return view('bk.detail-sesi', compact('konseling'));
    }

    /** Konseling Online - halaman chat BK */
    public function konselingOnline(Request $request)
    {
        $konseling = Konseling::with('user')->findOrFail($request->id);
        
        // Catat waktu mulai jika belum ada
        if (!$konseling->started_at) {
            $konseling->update(['started_at' => now()]);
        }

        return view('bk.konseling-online', compact('konseling'));
    }

    /** Form Konseling Offline - pencatatan hasil sesi offline */
    public function formKonselingOffline($id)
    {
        $konseling = Konseling::with('user')->findOrFail($id);
        
        // Cek jika started_at belum ada, beri fallback atau biarkan (sekarang lewat tombol Mulai)
        if (!$konseling->started_at) {
            $konseling->update(['started_at' => now()]);
        }

        return view('bk.form-konseling-offline', compact('konseling'));
    }

    /** Mulai Sesi Offline - eksplisit klik mulai */
    public function mulaiSesiOffline($id)
    {
        $konseling = Konseling::findOrFail($id);
        if (!$konseling->started_at) {
            $konseling->update(['started_at' => now()]);
        }
        return redirect()->route('bk.form-konseling-offline', $id);
    }

    /** Tandai Tidak Hadir - Siswa tidak datang ke sesi offline */
    public function tidakHadirOffline($id)
    {
        $konseling = Konseling::findOrFail($id);
        $konseling->update(['status' => 'tidak_hadir']);
        return redirect()->route('bk.sesi-konseling')->with('sukses', 'Siswa ditandai tidak hadir.');
    }


    /** Store form konseling offline – simpan catatan & selesaikan sesi */
    public function storeFormKonselingOffline(Request $request)
    {
        $request->validate([
            'konseling_id' => 'required|exists:konselings,id',
            'problem'      => 'required|string',
            'solution'     => 'required|string',
            'note'         => 'nullable|string',
        ]);



        $catatanFormatted = "Problem:\n" . $request->problem . "\n\nSolution:\n" . $request->solution;
        if ($request->note) {
            $catatanFormatted .= "\n\nNote:\n" . $request->note;
        }

        $konseling = Konseling::findOrFail($request->konseling_id);
        
        // Hitung durasi otomatis menit
        $durasi = 1;
        if ($konseling->started_at) {
            $durasi = max(1, now()->diffInMinutes($konseling->started_at));
        }

        $konseling->update([
            'status'     => 'selesai',
            'durasi'     => $durasi,
            'catatan_bk' => $catatanFormatted,
        ]);



        // Buat laporan otomatis dari sesi yang selesai
        Laporan::create([
            'nama_laporan' => 'Laporan Konseling: ' . $konseling->user->name,
            'author_id'    => auth()->id(),
            'user_id'      => $konseling->user_id,
            'konseling_id' => $konseling->id,
            'tanggal'      => now()->format('Y-m-d'),
            'search_key'   => now()->format('l, d F Y'),
        ]);

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
        $request->validate([
            'konseling_id' => 'required|exists:konselings,id',
            'problem'      => 'required|string',
            'solution'     => 'required|string',
            'note'         => 'nullable|string',
        ]);


        $catatanFormatted = "Problem:\n" . $request->problem . "\n\nSolution:\n" . $request->solution;
        if ($request->note) {
            $catatanFormatted .= "\n\nNote:\n" . $request->note;
        }

        $konseling = Konseling::findOrFail($request->konseling_id);
        
        // Hitung durasi otomatis menit
        $durasi = 1;
        if ($konseling->started_at) {
            $durasi = max(1, now()->diffInMinutes($konseling->started_at));
        }

        $konseling->update([
            'durasi'     => $durasi,
            'catatan_bk' => $catatanFormatted,
        ]);


        // Buat laporan otomatis
        Laporan::create([
            'nama_laporan' => 'Laporan Konseling: ' . $konseling->user->name,
            'author_id'    => auth()->id(),
            'user_id'      => $konseling->user_id,
            'konseling_id' => $konseling->id,
            'tanggal'      => now()->format('Y-m-d'),
            'search_key'   => now()->format('l, d F Y'),
        ]);

        return redirect()->route('bk.laporan-konseling')->with('sukses', 'Hasil konseling online berhasil dicatat dan laporan dibuat!');
    }

    /** Laporan Konseling - list laporan dari sesi selesai */
    public function laporanKonseling()
    {
        $laporans  = Laporan::with(['author', 'user', 'konseling'])->where('author_id', auth()->id())->latest()->paginate(10);

        return view('bk.laporan-konseling', compact('laporans'));
    }

    /** Detail Laporan (BK) */
    public function detailLaporan(Request $request)
    {
        $id = $request->query('id');
        $laporan = Laporan::with('author')->findOrFail($id);
        
        $items = collect(); // Default empty
        
        // Pemetaan 1-to-1 untuk Laporan yang di-generate otomatis (Laporan Konseling: Nama Siswa)
        if (str_starts_with($laporan->nama_laporan, 'Laporan Konseling: ')) {
            $namaSiswa = trim(str_replace('Laporan Konseling:', '', $laporan->nama_laporan));
            
            // Cari tahu ini Laporan ke-berapa untuk siswa tersebut (berdasarkan created_at)
            $userLaporans = Laporan::where('nama_laporan', $laporan->nama_laporan)
                ->orderBy('id', 'asc')->get();
            
            // Cari index dari laporan yang sedang dibuka (0, 1, 2, dll)
            $index = $userLaporans->search(function ($item) use ($laporan) {
                return $item->id == $laporan->id;
            });
            
            if ($index !== false) {
                // Ambil sesi Konseling ke-{index} dari siswa tersebut
                $konseling = Konseling::with('user')
                    ->where('status', 'selesai')
                    ->whereHas('user', function($q) use ($namaSiswa) {
                        $q->where('name', 'like', '%' . $namaSiswa . '%');
                    })
                    ->orderBy('id', 'asc') // Urutkan terlama pertama
                    ->skip($index)->first();
                    
                if ($konseling) {
                    $items = collect([$konseling]); // Masukkan 1 sesi secara spesifik
                }
            }
        } else {
            // Untuk laporan manual ("Semester Ganjil", dll)
            $items = Konseling::with('user')->where('status', 'selesai')->latest()->get();
        }
        
        return view('bk.detail-laporan', compact('laporan', 'items'));
    }
}
