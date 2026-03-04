<?php

namespace App\Http\Controllers;

use App\Events\PesanChatTerkirim;
use App\Models\Konseling;
use App\Models\Laporan;
use App\Models\PesanChat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Kirim pesan chat baru — simpan ke DB & broadcast via Reverb.
     */
    public function sendPesan(Request $request)
    {
        $request->validate([
            'konseling_id' => 'required|exists:konselings,id',
            'pesan'        => 'required|string|max:5000',
        ]);

        $konseling = Konseling::findOrFail($request->konseling_id);
        if (auth()->user()->role === 'bk' && $konseling->bk_id !== auth()->id()) abort(403, 'Unauthorized BK');
        if (auth()->user()->role === 'siswa' && $konseling->user_id !== auth()->id()) abort(403, 'Unauthorized Siswa');

        $pesan = PesanChat::create([
            'konseling_id' => $request->konseling_id,
            'user_id'      => auth()->id(),
            'pesan'        => $request->pesan,
        ]);

        $pesan->load('user');

        broadcast(new PesanChatTerkirim($pesan))->toOthers();

        return response()->json([
            'ok'    => true,
            'pesan' => [
                'id'         => $pesan->id,
                'user_id'    => $pesan->user_id,
                'user_name'  => $pesan->user->name,
                'user_role'  => $pesan->user->role,
                'pesan'      => $pesan->pesan,
                'created_at' => $pesan->created_at->toISOString(),
            ],
        ]);
    }

    /**
     * Ambil semua riwayat pesan untuk satu sesi konseling.
     */
    public function fetchPesan(Request $request)
    {
        $request->validate([
            'konseling_id' => 'required|exists:konselings,id',
        ]);

        $user     = auth()->user();
        $konselingId = $request->konseling_id;

        $konseling = Konseling::findOrFail($konselingId);
        if ($user->role === 'bk' && $konseling->bk_id !== $user->id) abort(403, 'Unauthorized BK');
        if ($user->role === 'siswa' && $konseling->user_id !== $user->id) abort(403, 'Unauthorized Siswa');

        $pesans = PesanChat::with('user')
            ->where('konseling_id', $konselingId)
            ->orderBy('created_at')
            ->get()
            ->map(fn($p) => [
                'id'         => $p->id,
                'user_id'    => $p->user_id,
                'user_name'  => $p->user->name,
                'user_role'  => $p->user->role,
                'pesan'      => $p->pesan,
                'created_at' => $p->created_at->toISOString(),
            ]);

        return response()->json(['ok' => true, 'pesans' => $pesans]);
    }

    /**
     * BK menyelesaikan sesi konseling → update status + buat laporan otomatis.
     */
    public function selesaiSesi(Request $request)
    {
        $request->validate([
            'konseling_id' => 'required|exists:konselings,id',
        ]);

        $konseling = Konseling::with('user')->findOrFail($request->konseling_id);
        if (auth()->user()->role === 'bk' && $konseling->bk_id !== auth()->id()) abort(403, 'Unauthorized BK');
        $konseling->update(['status' => 'selesai']);

        Laporan::create([
            'nama_laporan' => 'Laporan Konseling: ' . $konseling->user->name,
            'author_id'    => auth()->id(),
            'tanggal'      => now()->format('Y-m-d'),
            'search_key'   => now()->format('l, d F Y'),
        ]);

        return response()->json(['ok' => true]);
    }
}
