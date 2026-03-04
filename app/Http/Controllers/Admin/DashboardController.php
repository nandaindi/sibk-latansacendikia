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

        return view('admin.dashboard', compact('akunsCount', 'konselingsCount', 'laporansCount'));
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
        // TODO: simpan ke database
        return redirect()->route('admin.kelola-akun')->with('sukses', true);
    }

    /** Detail Akun */
    public function detailAkun()
    {
        return view('admin.detail-akun');
    }

    /** Edit Akun - form */
    public function editAkun()
    {
        return view('admin.edit-akun');
    }

    /** Update Akun */
    public function updateEditAkun(Request $request)
    {
        return redirect()->route('admin.detail-akun')->with('sukses', true);
    }

    /** Hapus Akun */
    public function destroyAkun()
    {
        return redirect()->route('admin.kelola-akun')->with('sukses', true);
    }

    /** Kelola Data - list daftar konseling */
    public function kelolaData()
    {
        $konselings = \App\Models\Konseling::with('user')->latest()->paginate(10);
        return view('admin.kelola-data', compact('konselings'));
    }

    /** Kelola Data - Detail Konseling */
    public function detailKonseling()
    {
        return view('admin.detail-konseling');
    }

    /** Kelola Data - Tambah Data Konseling */
    public function tambahData()
    {
        return view('admin.tambah-data');
    }

    /** Kelola Data - Store Tambah Data Konseling */
    public function storeTambahData(Request $request)
    {
        return redirect()->route('admin.kelola-data')->with('sukses', true);
    }

    /** Kelola Data - Edit Akun (Konseling) */
    public function editAkunData()
    {
        return view('admin.edit-akun-data');
    }

    /** Kelola Data - Update Edit Akun (Konseling) */
    public function updateEditAkunData(Request $request)
    {
        return redirect()->route('admin.kelola-data.detail')->with('sukses', true);
    }

    /** Kelola Laporan - list daftar laporan */
    public function kelolaLaporan()
    {
        $laporans = \App\Models\Laporan::with('author')->latest()->paginate(10);
        return view('admin.kelola-laporan', compact('laporans'));
    }

    /** Kelola Laporan - Detail */
    public function detailLaporan()
    {
        return view('admin.detail-laporan');
    }

    /** Kelola Laporan - Tambah Data Laporan */
    public function tambahLaporan()
    {
        return view('admin.tambah-laporan');
    }

    /** Kelola Laporan - Store Tambah Data Laporan */
    public function storeTambahLaporan(Request $request)
    {
        return redirect()->route('admin.kelola-laporan')->with('sukses', true);
    }

    /** Kelola Laporan - Edit Data Laporan */
    public function editLaporan()
    {
        return view('admin.edit-laporan');
    }

    /** Kelola Laporan - Update Edit Data Laporan */
    public function updateEditLaporan(Request $request)
    {
        return redirect()->route('admin.kelola-laporan.detail')->with('sukses', true);
    }

    /** Kelola Laporan - Hapus Data Laporan */
    public function destroyLaporan()
    {
        return redirect()->route('admin.kelola-laporan')->with('sukses', true);
    }
}
