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
        $siswaCount = \App\Models\User::where('role', 'siswa')->count();
        $bkCount = \App\Models\User::where('role', 'bk')->count();
        $laporans = \App\Models\Laporan::with('author')->latest()->paginate(10);

        return view('admin.dashboard', compact('akunsCount', 'konselingsCount', 'laporansCount', 'siswaCount', 'bkCount', 'laporans'));
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

    // ============================================================
    // DATA SISWA CRUD
    // ============================================================

    /** Data Siswa - List */
    public function dataSiswa(Request $request)
    {
        $query = \App\Models\User::where('role', 'siswa');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('nis', 'like', "%$search%")
                  ->orWhere('kelas', 'like', "%$search%");
            });
        }

        $siswa = $query->latest()->paginate(10);
        return view('admin.data-siswa', compact('siswa'));
    }

    /** Data Siswa - Form Tambah */
    public function tambahDataSiswa()
    {
        return view('admin.tambah-data-siswa');
    }

    /** Data Siswa - Store */
    public function storeDataSiswa(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:100',
            'nis'          => 'required|string|unique:users,nis',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:6',
            'kelas'        => 'nullable|string|max:20',
            'jurusan'      => 'nullable|string|max:50',
            'jenis_kelamin'=> 'nullable|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir'=> 'nullable|date',
            'alamat'       => 'nullable|string',
            'telepon'      => 'nullable|string|max:20',
            'nama_ortu'    => 'nullable|string|max:100',
            'telepon_ortu' => 'nullable|string|max:20',
        ]);

        \App\Models\User::create([
            'name'          => $request->nama,
            'nis'           => $request->nis,
            'username'      => $request->nis,
            'email'         => $request->email,
            'password'      => $request->password,
            'role'          => 'siswa',
            'kelas'         => $request->kelas,
            'jurusan'       => $request->jurusan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'telepon'       => $request->telepon,
            'nama_ortu'     => $request->nama_ortu,
            'telepon_ortu'  => $request->telepon_ortu,
        ]);

        return redirect()->route('admin.data-siswa')->with('sukses_tambah', true);
    }

    /** Data Siswa - Detail */
    public function detailDataSiswa(Request $request)
    {
        $user = \App\Models\User::where('role', 'siswa')->findOrFail($request->query('id'));
        return view('admin.detail-data-siswa', compact('user'));
    }

    /** Data Siswa - Form Edit */
    public function editDataSiswa(Request $request)
    {
        $user = \App\Models\User::where('role', 'siswa')->findOrFail($request->query('id'));
        return view('admin.edit-data-siswa', compact('user'));
    }

    /** Data Siswa - Update */
    public function updateDataSiswa(Request $request)
    {
        $user = \App\Models\User::where('role', 'siswa')->findOrFail($request->query('id'));

        $request->validate([
            'nama'         => 'required|string|max:100',
            'nis'          => 'required|string|unique:users,nis,' . $user->id,
            'kelas'        => 'nullable|string|max:20',
            'jurusan'      => 'nullable|string|max:50',
            'jenis_kelamin'=> 'nullable|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir'=> 'nullable|date',
            'alamat'       => 'nullable|string',
            'telepon'      => 'nullable|string|max:20',
            'nama_ortu'    => 'nullable|string|max:100',
            'telepon_ortu' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name'          => $request->nama,
            'nis'           => $request->nis,
            'kelas'         => $request->kelas,
            'jurusan'       => $request->jurusan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'telepon'       => $request->telepon,
            'nama_ortu'     => $request->nama_ortu,
            'telepon_ortu'  => $request->telepon_ortu,
        ]);

        return redirect()->route('admin.data-siswa')->with('sukses_edit', true);
    }

    /** Data Siswa - Hapus */
    public function destroyDataSiswa(Request $request)
    {
        $user = \App\Models\User::where('role', 'siswa')->findOrFail($request->query('id'));
        $user->delete();

        return redirect()->route('admin.data-siswa')->with('sukses_hapus', true);
    }

    // ============================================================
    // DATA BK CRUD
    // ============================================================

    /** Data BK - List */
    public function dataBk(Request $request)
    {
        $query = \App\Models\User::where('role', 'bk');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('nip', 'like', "%$search%")
                  ->orWhere('jabatan', 'like', "%$search%");
            });
        }

        $bk = $query->latest()->paginate(10);
        return view('admin.data-bk', compact('bk'));
    }

    /** Data BK - Form Tambah */
    public function tambahDataBk()
    {
        return view('admin.tambah-data-bk');
    }

    /** Data BK - Store */
    public function storeDataBk(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:6',
            'nip'          => 'nullable|string|max:30',
            'jenis_kelamin'=> 'nullable|in:L,P',
            'alamat'       => 'nullable|string',
            'telepon'      => 'nullable|string|max:20',
            'jabatan'      => 'nullable|string|max:100',
        ]);

        $username = explode('@', $request->email)[0] . rand(10, 99);
        while (\App\Models\User::where('username', $username)->exists()) {
            $username = explode('@', $request->email)[0] . rand(10, 99);
        }

        \App\Models\User::create([
            'name'          => $request->nama,
            'username'      => $username,
            'email'         => $request->email,
            'password'      => $request->password,
            'role'          => 'bk',
            'nip'           => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'        => $request->alamat,
            'telepon'       => $request->telepon,
            'jabatan'       => $request->jabatan,
        ]);

        return redirect()->route('admin.data-bk')->with('sukses_tambah', true);
    }

    /** Data BK - Detail */
    public function detailDataBk(Request $request)
    {
        $user = \App\Models\User::where('role', 'bk')->findOrFail($request->query('id'));
        return view('admin.detail-data-bk', compact('user'));
    }

    /** Data BK - Form Edit */
    public function editDataBk(Request $request)
    {
        $user = \App\Models\User::where('role', 'bk')->findOrFail($request->query('id'));
        return view('admin.edit-data-bk', compact('user'));
    }

    /** Data BK - Update */
    public function updateDataBk(Request $request)
    {
        $user = \App\Models\User::where('role', 'bk')->findOrFail($request->query('id'));

        $request->validate([
            'nama'         => 'required|string|max:100',
            'nip'          => 'nullable|string|max:30',
            'jenis_kelamin'=> 'nullable|in:L,P',
            'alamat'       => 'nullable|string',
            'telepon'      => 'nullable|string|max:20',
            'jabatan'      => 'nullable|string|max:100',
        ]);

        $user->update([
            'name'          => $request->nama,
            'nip'           => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'        => $request->alamat,
            'telepon'       => $request->telepon,
            'jabatan'       => $request->jabatan,
        ]);

        return redirect()->route('admin.data-bk')->with('sukses_edit', true);
    }

    /** Data BK - Hapus */
    public function destroyDataBk(Request $request)
    {
        $user = \App\Models\User::where('role', 'bk')->findOrFail($request->query('id'));
        $user->delete();

        return redirect()->route('admin.data-bk')->with('sukses_hapus', true);
    }
}

