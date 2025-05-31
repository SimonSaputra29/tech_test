<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PenggunaController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.pengguna.index', compact('users'));
    }

    public function create()
    {

        $roles = ['admin', 'guru', 'murid'];
        return view('admin.pengguna.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => ['required', Rule::in(['admin', 'guru', 'murid'])],
            'skill' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'identity_card' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        if ($request->hasFile('identity_card')) {
            $validated['identity_card'] = $request->file('identity_card')->store('identity_cards', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = ['admin', 'guru', 'murid'];

        return view('admin.pengguna.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'guru', 'murid'])],
            'skill' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'identity_card' => ['nullable', 'image', 'max:2048'],
        ]);

        // Hash password jika diisi
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Handle upload foto profil
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // Handle upload kartu identitas
        if ($request->hasFile('identity_card')) {
            if ($user->identity_card) {
                Storage::disk('public')->delete($user->identity_card);
            }
            $validated['identity_card'] = $request->file('identity_card')->store('identity_cards', 'public');
        }

        // Update data pengguna
        $user->update($validated);

        return redirect()->route('admin.pengguna.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // PenggunaController.php
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cegah pengguna admin menghapus dirinya sendiri (opsional)
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.pengguna.index')->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
