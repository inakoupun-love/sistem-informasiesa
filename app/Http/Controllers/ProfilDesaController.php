<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfilDesaController extends Controller
{
    public function index()
    {
        $kepalaDesa = User::where('role', 'kepala_desa')->orderBy('id')->first();

        return view('profildesa', compact('kepalaDesa'));
    }
}
