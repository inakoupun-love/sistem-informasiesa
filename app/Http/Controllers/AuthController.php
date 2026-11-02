<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the admin login form
     */
    public function showAdminLogin()
    {
        return view('admin.login');
    }

    /**
     * Show the kepala desa login form
     */
    public function showKepalaDesaLogin()
    {
        return view('kepaladesa.login');
    }

    /**
     * Show the masyarakat login form
     */
    public function showMasyarakatLogin()
    {
        return view('masyarakat.login');
    }

    /**
     * Show the combined login page (Masyarakat | Admin & Kepala Desa)
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login_field' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|in:admin,masyarakat,kepala_desa,petugas',
        ], [
            'login_field.required' => 'Username atau Nama Lengkap harus diisi',
            'password.required' => 'Password atau NIK harus diisi',
            'role.required' => 'Pilih role terlebih dahulu',
        ]);

        $role = $request->input('role');
        $loginField = $request->input('login_field');
        $password = $request->input('password');

        // Determine field to search based on role
        if ($role === 'masyarakat') {
            // Masyarakat login dengan nama lengkap dan NIK
            $user = User::where('name', $loginField)
                ->where('role', 'masyarakat')
                ->first();

            if (!$user || $user->nik !== $password) {
                throw ValidationException::withMessages([
                    'login_field' => 'Nama lengkap atau NIK tidak sesuai.',
                ]);
            }
        } else {
            // Admin dan Kepala Desa login dengan username dan password
            // Role 'petugas' = gabungan Admin & Kepala Desa (dideteksi otomatis)
            $roles = $role === 'petugas' ? ['admin', 'kepala_desa'] : [$role];

            $user = User::where('username', $loginField)
                ->whereIn('role', $roles)
                ->first();

            if (!$user || !Hash::check($password, $user->password)) {
                throw ValidationException::withMessages([
                    'login_field' => 'Username atau password tidak sesuai.',
                ]);
            }
        }

        // Check if user account is active
        if (!$user->isActive()) {
            throw ValidationException::withMessages([
                'login_field' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.',
            ]);
        }

        // Login the user
        Auth::login($user, $request->boolean('remember'));

        return redirect()->route('dashboard.redirect');
    }

    /**
     * Redirect to appropriate dashboard based on role
     */
    public function dashboardRedirect()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isKepalaDesa()) {
            return redirect()->route('kepala_desa.dashboard');
        } else {
            return redirect()->route('masyarakat.dashboard');
        }
    }

    /**
     * Show register form (untuk masyarakat saja)
     */
    public function showRegister()
    {
        return view('masyarakat.registrasi');
    }

    /**
     * Handle registration (masyarakat)
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|unique:users,nik|regex:/^\d{16}$/',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20|regex:/^[0-9+()\-\s]+$/',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'agama' => 'required|string|max:30',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:100',
            'alamat' => 'required|string|max:1000',
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'nik.required' => 'NIK harus diisi',
            'nik.regex' => 'NIK harus terdiri dari 16 angka',
            'nik.unique' => 'NIK sudah terdaftar di sistem',
            'email.unique' => 'Email sudah terdaftar di sistem',
            'phone.required' => 'Nomor telepon harus diisi',
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka dan simbol telepon yang valid',
        ]);

        // Create new masyarakat user
        $user = User::create([
            'name' => $validated['name'],
            'nik' => $validated['nik'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'agama' => $validated['agama'],
            'pendidikan' => $validated['pendidikan'],
            'pekerjaan' => $validated['pekerjaan'],
            'alamat' => $validated['alamat'],
            'password' => Hash::make($validated['nik']), // NIK as initial password
            'role' => 'masyarakat',
            'status' => 'active',
        ]);

        Auth::login($user);

        return redirect()->route('masyarakat.dashboard')->with('success', 'Registrasi berhasil. Selamat datang!');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil logout');
    }
}
