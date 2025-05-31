<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    public function show()
    {
        $admin = Auth::user();
        return view('profile.admin.show', compact('admin'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.admin.edit', compact('user'));
    }

    // Proses update profile
    public function update(HttpRequest $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048', // max 2MB
            'identity_card' => 'nullable|image|max:2048',
        ];

        if ($user->role === 'admin') {
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
}
