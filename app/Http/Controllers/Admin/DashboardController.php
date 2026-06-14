<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use App\Models\Laporan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /** Dashboard Admin */
    public function index()
    {
        $akunsCount = User::count();
        $konselingsCount = Konseling::count();
        $laporansCount = Laporan::count();
        $siswaCount = User::role('siswa')->count();
        $bkCount = User::role('bk')->count();
        $laporans = Laporan::with('author')->latest()->paginate(10);

        return view('admin.dashboard', compact('akunsCount', 'konselingsCount', 'laporansCount', 'siswaCount', 'bkCount', 'laporans'));
    }

    /** Kelola Akun - list akun */
    public function kelolaAkun(Request $request)
    {
        $RoleFilter = $request->query('role');
        $query = User::query();

        if ($RoleFilter) {
            $query->role($RoleFilter);
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
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'telepon' => 'nullable|string|max:20',
            'role' => 'required|in:admin',
            'password' => 'required|string|min:6',
        ]);

        $username = explode('@', $request->email)[0].rand(10, 99);

        while (User::where('username', $username)->exists()) {
            $username = explode('@', $request->email)[0].rand(10, 99);
        }

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'password' => $request->password,
            'username' => $username,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.kelola-akun')->with('sukses_tambah', true);
    }

    /** Detail Akun */
    public function detailAkun(Request $request)
    {
        $user = User::findOrFail($request->query('id'));

        return view('admin.detail-akun', compact('user'));
    }

    /** Edit Akun - form */
    public function editAkun(Request $request)
    {
        $user = User::findOrFail($request->query('id'));

        return view('admin.edit-akun', compact('user'));
    }

    /** Update Akun */
    public function updateEditAkun(Request $request)
    {
        $user = User::findOrFail($request->query('id'));

        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'telepon' => 'nullable|string|max:15',
            'role' => 'required|in:admin,bk,siswa',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.kelola-akun')->with('sukses_edit', true);
    }

    /** Hapus Akun */
    public function destroyAkun(Request $request)
    {
        $user = User::findOrFail($request->query('id'));
        $user->delete();

        return redirect()->route('admin.kelola-akun')->with('sukses_hapus', true);
    }

    /** Aktifkan Akun - Form */
    public function aktifkanAkun(Request $request)
    {
        $user = User::findOrFail($request->query('id'));

        return view('admin.aktifkan-akun', compact('user'));
    }

    /** Store Aktifkan Akun */
    public function storeAktifkanAkun(Request $request)
    {
        $user = User::findOrFail($request->query('id'));

        $request->validate([
            'username' => 'required|string|max:50|unique:users,username,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'required|string|min:6',
        ]);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('admin.kelola-akun')->with('sukses_aktivasi', true);
    }

    /** Kelola Data - list daftar konseling */
    public function kelolaData()
    {
        $konselings = Konseling::with('user')->latest()->paginate(10);

        return view('admin.kelola-data', compact('konselings'));
    }

    /** Kelola Data - Detail Konseling */
    public function detailKonseling(Request $request)
    {
        $konseling = Konseling::with(['user', 'bk'])->findOrFail($request->query('id'));

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
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'nis' => 'required|string|unique:users,nis|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'nis' => $request->nis,
            'password' => $request->password,
            'username' => $request->nis,
        ]);

        $user->assignRole('siswa');

        return redirect()->route('admin.kelola-data')->with('sukses_tambah', true);
    }

    /** Kelola Data - Edit Akun (Siswa) */
    public function editAkunData(Request $request)
    {
        $user = User::findOrFail($request->query('id'));

        return view('admin.edit-akun-data', compact('user'));
    }

    /** Kelola Data - Update Edit Akun (Siswa) */
    public function updateEditAkunData(Request $request)
    {
        $user = User::findOrFail($request->query('id'));

        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'nis' => 'required|string|unique:users,nis,'.$user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $request->nama,
            'email' => $request->email,
            'nis' => $request->nis,
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
        $konseling = Konseling::findOrFail($request->query('id'));
        $konseling->delete();

        return redirect()->route('admin.kelola-data')->with('sukses_hapus', true);
    }

    /** Kelola Laporan - list daftar laporan */
    public function kelolaLaporan()
    {
        $laporans = Laporan::with('author')->latest()->paginate(10);

        return view('admin.kelola-laporan', compact('laporans'));
    }

    /** Kelola Laporan - Detail */
    public function detailLaporan(Request $request)
    {
        $id = $request->query('id');
        $laporan = Laporan::with('author')->findOrFail($id);

        $items = collect();

        if (str_starts_with($laporan->nama_laporan, 'Laporan Konseling: ')) {
            $namaSiswa = trim(str_replace('Laporan Konseling:', '', $laporan->nama_laporan));

            $userLaporans = Laporan::where('nama_laporan', $laporan->nama_laporan)
                ->orderBy('id', 'asc')->get();

            $index = $userLaporans->search(function ($item) use ($laporan) {
                return $item->id == $laporan->id;
            });

            if ($index !== false) {

                $konseling = Konseling::with('user')
                    ->where('status', 'selesai')
                    ->whereHas('user', function ($q) use ($namaSiswa) {
                        $q->where('name', 'like', '%'.$namaSiswa.'%');
                    })
                    ->orderBy('id', 'asc')
                    ->skip($index)->first();

                if ($konseling) {
                    $items = collect([$konseling]);
                }
            }
        } else {

            $items = Konseling::with('user')->where('status', 'selesai')->latest()->get();
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
            'tanggal' => 'required|date',
        ]);

        $namaSiswa = trim(str_replace('Laporan Konseling:', '', $request->nama_laporan));
        $student = User::where('name', 'like', '%'.$namaSiswa.'%')->first();

        Laporan::create([
            'nama_laporan' => $request->nama_laporan,
            'tanggal' => $request->tanggal,
            'author_id' => auth()->id(),
            'user_id' => $student->id ?? null,
            'search_key' => Carbon::parse($request->tanggal)->format('l, d F Y'),
        ]);

        return redirect()->route('admin.kelola-laporan')->with('sukses_tambah', true);
    }

    /** Kelola Laporan - Edit Data Laporan */
    public function editLaporan(Request $request)
    {
        $laporan = Laporan::findOrFail($request->query('id'));

        return view('admin.edit-laporan', compact('laporan'));
    }

    /** Kelola Laporan - Update Edit Data Laporan */
    public function updateEditLaporan(Request $request)
    {
        $laporan = Laporan::findOrFail($request->query('id'));

        $request->validate([
            'nama_laporan' => 'required|string|max:200',
            'tanggal' => 'required|date',
        ]);

        $laporan->update([
            'nama_laporan' => $request->nama_laporan,
            'tanggal' => $request->tanggal,
            'search_key' => Carbon::parse($request->tanggal)->format('l, d F Y'),
        ]);

        return redirect()->route('admin.kelola-laporan')->with('sukses_edit', true);
    }

    /** Kelola Laporan - Hapus Data Laporan */
    public function destroyLaporan(Request $request)
    {
        $laporan = Laporan::findOrFail($request->query('id'));
        $laporan->delete();

        return redirect()->route('admin.kelola-laporan')->with('sukses_hapus', true);
    }

    /** Data Siswa - List */
    public function dataSiswa(Request $request)
    {
        $query = User::role('siswa');

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
            'nama' => 'required|string|max:100',
            'nis' => 'required|string|unique:users,nis',
            'kelas' => 'nullable|string|max:20',
            'jurusan' => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'nama_ortu' => 'nullable|string|max:100',
            'telepon_ortu' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'nis' => $request->nis,
            'username' => $request->nis,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'nama_ortu' => $request->nama_ortu,
            'telepon_ortu' => $request->telepon_ortu,
        ]);

        $user->assignRole('siswa');

        return redirect()->route('admin.data-siswa')->with('sukses_tambah', true);
    }

    /** Data Siswa - Detail */
    public function detailDataSiswa(Request $request)
    {
        $user = User::role('siswa')->findOrFail($request->query('id'));

        return view('admin.detail-data-siswa', compact('user'));
    }

    /** Data Siswa - Form Edit */
    public function editDataSiswa(Request $request)
    {
        $user = User::role('siswa')->findOrFail($request->query('id'));

        return view('admin.edit-data-siswa', compact('user'));
    }

    /** Data Siswa - Update */
    public function updateDataSiswa(Request $request)
    {
        $user = User::role('siswa')->findOrFail($request->query('id'));

        $request->validate([
            'nama' => 'required|string|max:100',
            'nis' => 'required|string|unique:users,nis,'.$user->id,
            'kelas' => 'nullable|string|max:20',
            'jurusan' => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'nama_ortu' => 'nullable|string|max:100',
            'telepon_ortu' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->nama,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'nama_ortu' => $request->nama_ortu,
            'telepon_ortu' => $request->telepon_ortu,
        ]);

        return redirect()->route('admin.data-siswa')->with('sukses_edit', true);
    }

    /** Data Siswa - Hapus */
    public function destroyDataSiswa(Request $request)
    {
        $user = User::role('siswa')->findOrFail($request->query('id'));
        $user->delete();

        return redirect()->route('admin.data-siswa')->with('sukses_hapus', true);
    }

    /** Data BK - List */
    public function dataBk(Request $request)
    {
        $query = User::role('bk');

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
            'nama' => 'required|string|max:100',
            'nip' => 'nullable|string|max:30',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'jabatan' => 'nullable|string|max:100',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'nip' => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'jabatan' => $request->jabatan,
        ]);

        $user->assignRole('bk');

        return redirect()->route('admin.data-bk')->with('sukses_tambah', true);
    }

    /** Data BK - Detail */
    public function detailDataBk(Request $request)
    {
        $user = User::role('bk')->findOrFail($request->query('id'));

        return view('admin.detail-data-bk', compact('user'));
    }

    /** Data BK - Form Edit */
    public function editDataBk(Request $request)
    {
        $user = User::role('bk')->findOrFail($request->query('id'));

        return view('admin.edit-data-bk', compact('user'));
    }

    /** Data BK - Update */
    public function updateDataBk(Request $request)
    {
        $user = User::role('bk')->findOrFail($request->query('id'));

        $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'nullable|string|max:30',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'jabatan' => 'nullable|string|max:100',
        ]);

        $user->update([
            'name' => $request->nama,
            'nip' => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('admin.data-bk')->with('sukses_edit', true);
    }

    /** Data BK - Hapus */
    public function destroyDataBk(Request $request)
    {
        $user = User::role('bk')->findOrFail($request->query('id'));
        $user->delete();

        return redirect()->route('admin.data-bk')->with('sukses_hapus', true);
    }
}
