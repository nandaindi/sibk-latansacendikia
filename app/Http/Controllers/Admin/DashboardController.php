<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /** Dashboard Admin */
    public function index()
    {
        $akunsCount = \App\Models\User::count();
        $konselingsCount = \App\Models\Konseling::count();
        $laporansCount = \App\Models\Laporan::count();
        $laporans = \App\Models\Laporan::with('author')->latest()->paginate(10);

        return view('admin.dashboard', compact('akunsCount', 'konselingsCount', 'laporansCount', 'laporans'));
    }

    /** Kelola Akun - list akun */
    public function kelolaAkun(Request $request)
    {
        $RoleFilter = $request->query('role');
        $query = \App\Models\User::query();

        if ($RoleFilter) {
            $query->where('role', $RoleFilter);
        }
        
        $akuns = $query->latest()->paginate(10);
        return view('admin.kelola-akun', compact('akuns'));
    }

    /** Tambah Akun - form */
    public function tambahAkun()
    {
        return view('admin.tambah-akun');
    }

    /** Store tambah akun */
    public function storeTambahAkun(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'telepon'  => 'nullable|string|max:20',
            'role'     => 'required|in:admin,bk,siswa',
            'password' => 'required|string|min:6',
        ]);

        $username = explode('@', $request->email)[0] . rand(10, 99);
        
        // Ensure username is unique
        while (\App\Models\User::where('username', $username)->exists()) {
            $username = explode('@', $request->email)[0] . rand(10, 99);
        }

        \App\Models\User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'telepon'  => $request->telepon,
            'role'     => $request->role,
            'password' => $request->password, 
            'username' => $username,
        ]);

        return redirect()->route('admin.kelola-akun')->with('sukses_tambah', true);
    }

    /** Detail Akun */
    public function detailAkun(Request $request)
    {
        $user = \App\Models\User::findOrFail($request->query('id'));
        return view('admin.detail-akun', compact('user'));
    }

    /** Edit Akun - form */
    public function editAkun(Request $request)
    {
        $user = \App\Models\User::findOrFail($request->query('id'));
        return view('admin.edit-akun', compact('user'));
    }

    /** Update Akun */
    public function updateEditAkun(Request $request)
    {
        $user = \App\Models\User::findOrFail($request->query('id'));
        
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'telepon'  => 'nullable|string|max:15',
            'role'     => 'required|in:admin,bk,siswa',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name'    => $request->nama,
            'email'   => $request->email,
            'telepon' => $request->telepon,
            'role'    => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('admin.kelola-akun')->with('sukses_edit', true);
    }

    /** Hapus Akun */
    public function destroyAkun(Request $request)
    {
        $user = \App\Models\User::findOrFail($request->query('id'));
        $user->delete();

        return redirect()->route('admin.kelola-akun')->with('sukses_hapus', true);
    }

    /** Kelola Data - list daftar konseling */
    public function kelolaData()
    {
        $konselings = \App\Models\Konseling::with('user')->latest()->paginate(10);
        return view('admin.kelola-data', compact('konselings'));
    }

    /** Kelola Data - Detail Konseling */
    public function detailKonseling(Request $request)
    {
        $konseling = \App\Models\Konseling::with(['user', 'bk'])->findOrFail($request->query('id'));
        return view('admin.detail-konseling', compact('konseling'));
    }

    /** Kelola Data - Tambah Data Konseling (Siswa actually) */
    public function tambahData()
    {
        return view('admin.tambah-data');
    }

    /** Kelola Data - Store Tambah Data (Siswa) */
    public function storeTambahData(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'nis'      => 'required|string|unique:users,nis|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        \App\Models\User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'nis'      => $request->nis,
            'role'     => 'siswa',
            'password' => $request->password,
            'username' => $request->nis,
        ]);

        return redirect()->route('admin.kelola-data')->with('sukses_tambah', true);
    }

    /** Kelola Data - Edit Akun (Siswa) */
    public function editAkunData(Request $request)
    {
        $user = \App\Models\User::findOrFail($request->query('id'));
        return view('admin.edit-akun-data', compact('user'));
    }

    /** Kelola Data - Update Edit Akun (Siswa) */
    public function updateEditAkunData(Request $request)
    {
        $user = \App\Models\User::findOrFail($request->query('id'));
        
        $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nis'   => 'required|string|unique:users,nis,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name'  => $request->nama,
            'email' => $request->email,
            'nis'   => $request->nis,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('admin.kelola-data')->with('sukses_edit', true);
    }

    /** Kelola Data - Hapus Konseling */
    public function destroyData(Request $request)
    {
        $konseling = \App\Models\Konseling::findOrFail($request->query('id'));
        $konseling->delete();

        return redirect()->route('admin.kelola-data')->with('sukses_hapus', true);
    }

    /** Kelola Laporan - list daftar laporan */
    public function kelolaLaporan()
    {
        $laporans = \App\Models\Laporan::with('author')->latest()->paginate(10);
        return view('admin.kelola-laporan', compact('laporans'));
    }

    /** Kelola Laporan - Detail */
    public function detailLaporan(Request $request)
    {
        $id = $request->query('id');
        $laporan = \App\Models\Laporan::with('author')->findOrFail($id);
        
        $items = collect(); // Default empty
        
        // Pemetaan 1-to-1 untuk Laporan yang di-generate otomatis (Laporan Konseling: Nama Siswa)
        if (str_starts_with($laporan->nama_laporan, 'Laporan Konseling: ')) {
            $namaSiswa = trim(str_replace('Laporan Konseling:', '', $laporan->nama_laporan));
            
            // Cari tahu ini Laporan ke-berapa untuk siswa tersebut (berdasarkan created_at)
            $userLaporans = \App\Models\Laporan::where('nama_laporan', $laporan->nama_laporan)
                ->orderBy('id', 'asc')->get();
            
            // Cari index dari laporan yang sedang dibuka (0, 1, 2, dll)
            $index = $userLaporans->search(function ($item) use ($laporan) {
                return $item->id == $laporan->id;
            });
            
            if ($index !== false) {
                // Ambil sesi Konseling ke-{index} dari siswa tersebut
                $konseling = \App\Models\Konseling::with('user')
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
            // Tampilkan daftar semua sesi dalam periode terkait? Atau limit ke 10 sesi terakhir.
            // Sesuai permintaan "hanya melihat 1 detail... begitupun yang lain", mungkin kita tidak paksa tampilkan semuanya,
            // Atau cukup limit ke data terbaru jika itu rekap. 
            $items = \App\Models\Konseling::with('user')->where('status', 'selesai')->latest()->get();
        }
        
        return view('admin.detail-laporan', compact('laporan', 'items'));
    }

    /** Kelola Laporan - Tambah Data Laporan */
    public function tambahLaporan()
    {
        return view('admin.tambah-laporan');
    }

    /** Kelola Laporan - Store Tambah Data Laporan */
    public function storeTambahLaporan(Request $request)
    {
        $request->validate([
            'nama_laporan' => 'required|string|max:200',
            'tanggal'      => 'required|date',
        ]);

        $namaSiswa = trim(str_replace('Laporan Konseling:', '', $request->nama_laporan));
        $student = \App\Models\User::where('name', 'like', '%' . $namaSiswa . '%')->first();

        \App\Models\Laporan::create([
            'nama_laporan' => $request->nama_laporan,
            'tanggal'      => $request->tanggal,
            'author_id'    => auth()->id(),
            'user_id'      => $student->id ?? null,
            'search_key'   => \Carbon\Carbon::parse($request->tanggal)->format('l, d F Y'),
        ]);

        return redirect()->route('admin.kelola-laporan')->with('sukses_tambah', true);
    }

    /** Kelola Laporan - Edit Data Laporan */
    public function editLaporan(Request $request)
    {
        $laporan = \App\Models\Laporan::findOrFail($request->query('id'));
        return view('admin.edit-laporan', compact('laporan'));
    }

    /** Kelola Laporan - Update Edit Data Laporan */
    public function updateEditLaporan(Request $request)
    {
        $laporan = \App\Models\Laporan::findOrFail($request->query('id'));

        $request->validate([
            'nama_laporan' => 'required|string|max:200',
            'tanggal'      => 'required|date',
        ]);

        $laporan->update([
            'nama_laporan' => $request->nama_laporan,
            'tanggal'      => $request->tanggal,
            'search_key'   => \Carbon\Carbon::parse($request->tanggal)->format('l, d F Y'),
        ]);

        return redirect()->route('admin.kelola-laporan')->with('sukses_edit', true);
    }

    /** Kelola Laporan - Hapus Data Laporan */
    public function destroyLaporan(Request $request)
    {
        $laporan = \App\Models\Laporan::findOrFail($request->query('id'));
        $laporan->delete();

        return redirect()->route('admin.kelola-laporan')->with('sukses_hapus', true);
    }
}
