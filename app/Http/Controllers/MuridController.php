<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MuridController extends Controller
{
    public function index()
    {
        return view('murid.index');
    }

    public function show($id)
    {
        $murid = User::where('role', 'murid')->findOrFail($id);

        // Cek siapa yang akses
        $currentUser = auth()->user();

        // Kalau kamu mau, boleh buat aturan siapa bisa lihat profil murid
        // Contoh, guru dan admin boleh lihat, murid lain gak boleh
        if (!in_array($currentUser->role, ['guru', 'admin'])) {
            abort(403, "You don't have access to view this profile");
        }

        return view('profile.murid.show', compact('murid'));
    }
}
