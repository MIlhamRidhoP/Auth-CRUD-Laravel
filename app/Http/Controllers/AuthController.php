<?php
// Menandakan bahwa file ini adalah file PHP

namespace App\Http\Controllers;
// Namespace menunjukkan lokasi controller ini berada

use App\Models\User;
// Model User digunakan untuk menyimpan & mengambil data user dari database

use Illuminate\Http\Request;
// Request digunakan untuk mengambil data dari HTTP request (form, input, dll)

use Illuminate\Support\Facades\Auth;
// Facade Auth digunakan untuk proses authentication (login, logout, cek user)

use Illuminate\Support\Facades\Hash;
// Facade Hash digunakan untuk mengenkripsi (hash) password

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     * -------------------------
     * Diakses melalui route GET /login
     */
    public function showLogin()
    {
        // Mengembalikan view resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Menampilkan halaman register
     * ----------------------------
     * Diakses melalui route GET /register
     */
    public function showRegister()
    {
        // Mengembalikan view resources/views/auth/register.blade.php
        return view('auth.register');
    }

    /**
     * Proses register user baru
     * -------------------------
     * Diakses melalui route POST /register
     */
    public function register(Request $request)
    {
        /**
         * Validasi input dari form register
         * --------------------------------
         * name     : wajib diisi
         * email    : wajib, format email, dan harus unik di tabel users
         * password : wajib, minimal 6 karakter, dan harus dikonfirmasi
         */
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        /**
         * Membuat user baru di database
         * -----------------------------
         * password di-hash agar aman
         * role diset 'user' secara default
         */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        /**
         * Login otomatis setelah register
         * -------------------------------
         * Auth::login() menyimpan user ke session
         */
        Auth::login($user);

        /**
         * Regenerate session ID
         * ---------------------
         * Untuk mencegah serangan session fixation
         */
        $request->session()->regenerate();

        // Setelah register & login, user diarahkan ke dashboard
        return redirect('/dashboard');
    }

    /**
     * Proses login user
     * -----------------
     * Diakses melalui route POST /login
     */
    public function login(Request $request)
    {
        /**
         * Auth::attempt()
         * ---------------
         * Mengecek apakah email & password cocok
         * Password otomatis dibandingkan dengan hash di database
         */
        if (Auth::attempt($request->only('email', 'password'))) {

            // Jika login berhasil, regenerate session
            $request->session()->regenerate();

            // Arahkan user ke dashboard
            return redirect('/dashboard');
        }

        /**
         * Jika login gagal
         * ----------------
         * Kembali ke halaman login dengan pesan error
         */
        return back()->withErrors([
            'email' => 'Login gagal',
        ]);
    }

    /**
     * Proses logout user
     * ------------------
     * Diakses melalui route POST /logout
     */
    public function logout(Request $request)
    {
        /**
         * Menghapus data authentication user
         */
        Auth::logout();

        /**
         * Menghapus seluruh data session
         * -------------------------------
         * Supaya session lama tidak bisa dipakai lagi
         */
        $request->session()->invalidate();

        /**
         * Membuat token CSRF baru
         * -----------------------
         * Untuk keamanan setelah logout
         */
        $request->session()->regenerateToken();

        // Setelah logout, user diarahkan ke halaman login
        return redirect('/login');
    }
}
