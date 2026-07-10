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

        if ($user->hasRole('admin')) {
            return view('admin.profile', compact('user'));
        } elseif ($user->hasRole('bk')) {
            return view('bk.profile', compact('user'));
        } elseif ($user->hasRole('siswa')) {
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

        $rules = [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];

        if ($user->hasRole('admin')) {
            $rules['name'] = ['required', 'string', 'max:255'];
        }

        $validated = $request->validate($rules);

        if ($user->hasRole('admin') && isset($validated['name'])) {
            $user->name = $validated['name'];
        }
        
        $user->email = $validated['email'];

        if ($request->hasFile('avatar')) {

            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
