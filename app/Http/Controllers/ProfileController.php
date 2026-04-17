<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman edit profil sesuai role pengguna.
     */
    public function edit()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return view('admin.profile', compact('user'));
        } elseif ($user->role === 'bk') {
            return view('bk.profile', compact('user'));
        } elseif ($user->role === 'siswa') {
            return view('siswa.profile', compact('user'));
        }

        abort(403, 'Unauthorized action.');
    }

    /**
     * Proses update data profil pengguna.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Handle Avatar Upload
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika bukan null
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Simpan yang baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // Cek apakah password diisi (jika tidak kosong berarti ingin diubah)
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Redirect back dengan pesan sukses sesuai role
        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
