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
            'nomor_induk' => ['nullable', 'string', 'max:50'],
            'telepon' => ['nullable', 'string', 'max:20'],
            'kelas' => ['nullable', 'string', 'max:50'],
            'jurusan_select' => ['nullable', 'string', Rule::in(['IPA', 'IPS'])],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        // Simpan nomor induk / nip jika ada di validasi
        if (isset($validated['nomor_induk'])) {
            $user->nomor_induk = $validated['nomor_induk'];
        }
        
        // Simpan nomor telepon jika ada di validasi
        if (isset($validated['telepon'])) {
            $user->telepon = $validated['telepon'];
        }

        // Simpan kelas jika ada di validasi (khusus siswa)
        if (isset($validated['kelas'])) {
            $user->kelas = $validated['kelas'];
        }

        // Simpan jurusan jika ada di validasi (khusus siswa)
        if (isset($validated['jurusan_select'])) {
            $user->jurusan = $validated['jurusan_select'];
        }

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
