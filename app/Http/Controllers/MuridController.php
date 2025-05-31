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
        $murid = User::where('id', $id)->where('role', 'murid')->firstOrFail();
        return view('profile.murid.show', compact('murid'));
    }
}
