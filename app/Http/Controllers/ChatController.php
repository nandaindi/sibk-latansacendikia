<?php

namespace App\Http\Controllers;

use App\Events\PesanChatTerkirim;
use App\Models\Konseling;
use App\Models\PesanChat;
use App\Notifications\KonselingStatusNotification;
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
        $this->authorizeKonseling($konseling);

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
                'user_role'  => $pesan->user->getRoleNames()->first(),
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

        $konseling = Konseling::findOrFail($request->konseling_id);
        $this->authorizeKonseling($konseling);

        $pesans = PesanChat::with('user')
            ->where('konseling_id', $konseling->id)
            ->orderBy('created_at')
            ->get()
            ->map(fn ($p) => [
                'id'         => $p->id,
                'user_id'    => $p->user_id,
                'user_name'  => $p->user->name,
                'user_role'  => $p->user->getRoleNames()->first(),
                'pesan'      => $p->pesan,
                'created_at' => $p->created_at->toISOString(),
            ]);

        return response()->json(['ok' => true, 'pesans' => $pesans]);
    }

    /**
     * BK menyelesaikan sesi konseling → update status.
     */
    public function selesaiSesi(Request $request)
    {
        $request->validate([
            'konseling_id' => 'required|exists:konselings,id',
        ]);

        $konseling = Konseling::with('user')->findOrFail($request->konseling_id);
        $this->authorizeKonseling($konseling, bkOnly: true);

        $konseling->update(['status' => 'selesai']);

        if ($konseling->user) {
            $konseling->user->notify(new KonselingStatusNotification($konseling, 'selesai'));
        }

        return response()->json([
            'ok' => true,
            'id' => $konseling->id,
        ]);
    }

    // ─── Private Helpers ──────────────────────────────────────────────────────

    /**
     * Pastikan user yang sedang login adalah peserta yang sah dalam sesi ini.
     * BK harus bk_id yang sesuai, siswa harus user_id yang sesuai.
     */
    private function authorizeKonseling(Konseling $konseling, bool $bkOnly = false): void
    {
        $user = auth()->user();

        if ($user->hasRole('bk') && (int) $konseling->bk_id !== (int) $user->id) {
            abort(403, 'Unauthorized BK');
        }

        if (! $bkOnly && $user->hasRole('siswa') && (int) $konseling->user_id !== (int) $user->id) {
            abort(403, 'Unauthorized Siswa');
        }
    }
}
