<?php
// Menandakan file ini adalah file PHP

namespace App\Http\Middleware;
// Namespace menunjukkan bahwa file ini adalah middleware
// Lokasinya di folder app/Http/Middleware

use Closure;
// Closure adalah fungsi anonim (callback)
// Digunakan untuk meneruskan request ke proses selanjutnya

use Illuminate\Http\Request;
// Request digunakan untuk mengambil data dari HTTP request
// Contoh: user login, input form, dll

use Symfony\Component\HttpFoundation\Response;
// Response adalah tipe data balikan dari middleware
// Laravel menggunakan Response dari Symfony

class RoleMiddleware
{
    /**
     * Method handle()
     * ----------------
     * Method utama middleware
     * Akan dipanggil SETIAP KALI route yang memakai middleware ini diakses
     *
     * Parameter:
     * - Request $request  → data request HTTP
     * - Closure $next     → proses selanjutnya (controller / middleware lain)
     * - string $role      → parameter role dari route (contoh: role:admin)
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        /**
         * Mengambil user yang sedang login
         * --------------------------------
         * Sama dengan auth()->user()
         * Tapi lebih aman & jelas dipakai di Laravel 11/12
         */
        $user = $request->user();

        /**
         * Cek apakah:
         * 1. User belum login
         * 2. ATAU role user tidak sesuai dengan role yang diminta route
         */
        if (!$user || $user->role !== $role) {

            /**
             * abort(403)
             * ----------
             * Menghentikan proses dan menampilkan error 403 (Forbidden)
             * Artinya user TIDAK PUNYA HAK AKSES
             */
            abort(403, 'Akses ditolak');
        }

        /**
         * Jika user login dan role sesuai
         * --------------------------------
         * Request diteruskan ke proses berikutnya
         * (middleware selanjutnya atau controller)
         */
        return $next($request);
    }
}
