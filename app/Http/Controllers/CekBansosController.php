<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bansos;

class CekBansosController extends Controller
{
    public function index(Request $request)
    {
        $user = null;
        $bansosList = collect();

        if ($request->filled('nik')) {
            $user = User::where('nik', $request->nik)
                ->where('role', 'masyarakat')
                ->first();

            if ($user) {
                $bansosList = Bansos::with('jenisBansos')
                    ->where('user_id', $user->id)
                    ->where('status', 'disetujui')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        return view('cekbansos', compact('user', 'bansosList'));
    }
}