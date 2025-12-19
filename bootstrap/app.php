<?php
// Menandakan bahwa ini adalah file PHP
// File ini adalah ENTRY POINT konfigurasi aplikasi Laravel 11/12

use Illuminate\Foundation\Application;
// Class utama Laravel Application
// Digunakan untuk mengkonfigurasi aplikasi dari awal

use Illuminate\Foundation\Configuration\Exceptions;
// Digunakan untuk mengatur bagaimana exception (error) ditangani

use Illuminate\Foundation\Configuration\Middleware;
// Digunakan untuk mendaftarkan middleware (pengganti Kernel.php)

use App\Http\Middleware\RoleMiddleware;
// Import middleware RoleMiddleware yang kita buat sendiri

/**
 * Application::configure()
 * ------------------------
 * Method utama untuk mengkonfigurasi aplikasi Laravel
 * basePath menunjuk ke root folder project
 */
return Application::configure(basePath: dirname(__DIR__))

    /**
     * withRouting()
     * -------------
     * Menentukan file routing yang digunakan aplikasi
     */
    ->withRouting(
        // Route untuk web (browser)
        web: __DIR__.'/../routes/web.php',

        // Route untuk console / artisan
        commands: __DIR__.'/../routes/console.php',

        // Health check endpoint (default Laravel 11+)
        health: '/up',
    )

    /**
     * withMiddleware()
     * ----------------
     * TEMPAT PENGGANTI app/Http/Kernel.php
     * Digunakan untuk mendaftarkan middleware global dan alias middleware
     */
    ->withMiddleware(function (Middleware $middleware): void {

        /**
         * alias()
         * -------
         * Mendaftarkan middleware dengan nama singkat
         *
         * 'role' → nama middleware yang dipakai di route
         * RoleMiddleware::class → class middleware yang dijalankan
         *
         * Contoh penggunaan di routes:
         * Route::middleware('role:admin')->group(...)
         */
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
    })

    /**
     * withExceptions()
     * ----------------
     * Digunakan untuk konfigurasi penanganan error (exception)
     * 
     * Di project ini tidak dikustomisasi,
     * jadi dibiarkan kosong
     */
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    /**
     * create()
     * --------
     * Membuat instance aplikasi Laravel
     * TANPA ini, aplikasi tidak akan berjalan
     */
    ->create();
