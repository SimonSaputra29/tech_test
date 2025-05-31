<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Tampilkan form edit profile
    public function edit()
    {
        $user = Auth::user();
        return view('profile.murid.edit', compact('user'));
    }

    // Proses update profile
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048', // max 2MB
            'identity_card' => 'nullable|image|max:2048',
        ];

        if ($user->role === 'guru') {
            $rules['skill'] = 'nullable|string';
        } elseif ($user->role === 'murid') {
            // Murid bisa update bidang pelatihan di skill juga misal
            $rules['skill'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        // Upload photo profile jika ada
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $path;
        }

        // Upload identity_card (KTP/kartu pelajar) jika ada
        if ($request->hasFile('identity_card')) {
            if ($user->identity_card) {
                Storage::disk('public')->delete($user->identity_card);
            }
            $path = $request->file('identity_card')->store('identity_cards', 'public');
            $validated['identity_card'] = $path;
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Profile berhasil diperbarui');
    }

    // Tampilkan profile user
    public function show()
    {
        $murid = Auth::user();
        return view('profile.murid.show', compact('murid'));
    }
}
