<?php

namespace App\Http\Controllers\BK;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\User;
use Illuminate\Http\Request;

class PemanggilanController extends Controller
{
    public function index()
    {
        $siswas = User::role('siswa')->orderBy('name')->get();

        return view('bk.panggil-siswa', compact('siswas'));
    }

    /** List calling history (Pelanggaran) */
    public function riwayat(Request $request)
    {
        $status = $request->query('status');

        $query = Pelanggaran::with('user')->where('bk_id', auth()->id());
        if ($status && in_array($status, ['menunggu', 'selesai', 'tidak_hadir'])) {
            $query->where('status', $status);
        }
        $riwayatPanggilan = $query->latest()->paginate(10)->withQueryString();

        return view('bk.riwayat-panggilan', compact('riwayatPanggilan', 'status'));
    }

    /** Store student calling for violation (Pelanggaran) */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'topik' => 'required|string|max:200',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'catatan' => 'required|string|max:1000',
        ]);

        if (! User::role('siswa')->whereKey($request->user_id)->exists()) {
            return back()->withInput()->with('error', 'Siswa yang dipilih tidak valid.');
        }

        if (now()->gt(\Carbon\Carbon::parse($request->tanggal . ' ' . $request->waktu))) {
            return back()->withInput()->with('error', 'Waktu panggilan tidak boleh di masa lalu.');
        }

        Pelanggaran::create([
            'user_id' => $request->user_id,
            'bk_id' => auth()->id(),
            'topik' => $request->topik,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'status' => 'menunggu',
            'catatan_pemanggilan' => $request->catatan,
        ]);

        return redirect()->route('bk.riwayat-panggilan')->with('sukses', 'Siswa berhasil dipanggil untuk kasus pelanggaran!');
    }

    /** View detail / form to finish violation */
    public function detail($id)
    {
        $pelanggaran = Pelanggaran::with('user')->where('bk_id', auth()->id())->findOrFail($id);

        return view('bk.detail-pelanggaran', compact('pelanggaran'));
    }

    /** Update violation status to selesai */
    public function update(Request $request, $id)
    {
        $request->validate([
            'catatan_hasil' => 'required|string|max:2000',
            'catatan_tindak_lanjut' => 'required|string|max:2000',
            'status' => 'required|in:selesai,tidak_hadir',
        ]);

        $pelanggaran = Pelanggaran::where('bk_id', auth()->id())->where('status', 'menunggu')->findOrFail($id);
        $pelanggaran->update([
            'status' => $request->status,
            'catatan_hasil' => $request->catatan_hasil,
            'catatan_tindak_lanjut' => $request->catatan_tindak_lanjut,
        ]);

        return redirect()->route('bk.riwayat-panggilan')->with('sukses', 'Status pelanggaran berhasil diperbarui!');
    }
}
