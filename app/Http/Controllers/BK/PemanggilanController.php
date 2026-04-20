<?php

namespace App\Http\Controllers\BK;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\User;
use Illuminate\Http\Request;

class PemanggilanController extends Controller
{
    /** List students and calling history (Pelanggaran) */
    public function index()
    {
        $siswas = User::where('role', 'siswa')->orderBy('name')->get();
        
        $riwayatPanggilan = Pelanggaran::with('user')
            ->where('bk_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('bk.panggil-siswa', compact('siswas', 'riwayatPanggilan'));
    }

    /** Store student calling for violation (Pelanggaran) */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'topik'   => 'required|string|max:200',
            'tanggal' => 'required|date',
            'waktu'   => 'required',
            'catatan' => 'required|string|max:1000',
        ]);

        Pelanggaran::create([
            'user_id'             => $request->user_id,
            'bk_id'               => auth()->id(),
            'topik'               => $request->topik,
            'tanggal'             => $request->tanggal,
            'waktu'               => $request->waktu,
            'status'              => 'menunggu',
            'catatan_pemanggilan' => $request->catatan,
        ]);

        return redirect()->route('bk.panggil-siswa.index')->with('sukses', 'Siswa berhasil dipanggil untuk kasus pelanggaran!');
    }

    /** View detail / form to finish violation */
    public function detail($id)
    {
        $pelanggaran = Pelanggaran::with('user')->findOrFail($id);
        return view('bk.detail-pelanggaran', compact('pelanggaran'));
    }

    /** Update violation status to selesai */
    public function update(Request $request, $id)
    {
        $request->validate([
            'catatan_hasil'         => 'required|string|max:2000',
            'catatan_tindak_lanjut' => 'required|string|max:2000',
            'status'                => 'required|in:selesai,tidak_hadir',
        ]);

        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->update([
            'status'                => $request->status,
            'catatan_hasil'         => $request->catatan_hasil,
            'catatan_tindak_lanjut' => $request->catatan_tindak_lanjut,
        ]);

        return redirect()->route('bk.panggil-siswa.index')->with('sukses', 'Status pelanggaran berhasil diperbarui!');
    }
}
