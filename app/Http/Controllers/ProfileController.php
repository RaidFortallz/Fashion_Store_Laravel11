<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna.
     */
    public function show()
    {
        $user = Auth::user();
        return view('themes.jawique.profile.show', compact('user'));
    }

    /**
     * Mengupdate data profil pengguna.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:15',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // DITAMBAHKAN: Validasi untuk avatar
        ]);

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }
}
