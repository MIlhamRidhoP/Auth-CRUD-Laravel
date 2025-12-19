<?php

/**
 * ==========================================================
 * Import Controller yang akan digunakan oleh route
 * ==========================================================
 */
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/**
 * ==========================================================
 * DEFAULT ROUTE
 * ==========================================================
 * Ketika user mengakses root URL ( / ),
 * sistem akan langsung mengarahkan ke halaman login.
 */
Route::get('/', fn () => redirect('/login'));

/**
 * ==========================================================
 * ROUTE UNTUK GUEST (BELUM LOGIN)
 * ==========================================================
 * Middleware 'guest' memastikan bahwa:
 * - User yang SUDAH LOGIN tidak bisa mengakses halaman login/register
 * - Mencegah user login membuka ulang halaman login
 */
Route::middleware('guest')->group(function () {

    /**
     * Menampilkan halaman login
     * Method: GET
     * Controller: AuthController@showLogin
     */
    Route::get('/login', [AuthController::class, 'showLogin']);

    /**
     * Proses login user
     * Method: POST
     * Controller: AuthController@login
     */
    Route::post('/login', [AuthController::class, 'login']);

    /**
     * Menampilkan halaman register
     * Method: GET
     * Controller: AuthController@showRegister
     */
    Route::get('/register', [AuthController::class, 'showRegister']);

    /**
     * Proses registrasi user baru
     * Method: POST
     * Controller: AuthController@register
     */
    Route::post('/register', [AuthController::class, 'register']);
});

/**
 * ==========================================================
 * ROUTE UNTUK USER YANG SUDAH LOGIN
 * ==========================================================
 * Middleware 'auth' memastikan bahwa:
 * - Hanya user yang sudah login yang bisa mengakses route di dalamnya
 * - Jika belum login, user akan diarahkan ke halaman login
 */
Route::middleware('auth')->group(function () {

    /**
     * Dashboard user
     * Akan menampilkan dashboard berbeda berdasarkan role:
     * - Admin -> dashboard admin
     * - User  -> dashboard user
     */
    Route::get('/dashboard', [DashboardController::class, 'index']);

    /**
     * Logout user
     * Method: POST
     * Controller: AuthController@logout
     * Mengakhiri session user
     */
    Route::post('/logout', [AuthController::class, 'logout']);

    /**
     * ======================================================
     * ROUTE BUKU (READ ONLY UNTUK SEMUA USER)
     * ======================================================
     * Semua user yang sudah login (admin & user) bisa:
     * - Melihat daftar buku
     */
    Route::get('/books', [BookController::class, 'index']);

    /**
     * ======================================================
     * ROUTE ADMIN ONLY (CRUD BUKU)
     * ======================================================
     * Middleware 'role:admin' memastikan bahwa:
     * - Hanya user dengan role = admin yang bisa mengakses
     * - User biasa akan mendapatkan error 403
     */
    Route::middleware('role:admin')->group(function () {

        /**
         * Menampilkan form tambah buku
         * Method: GET
         */
        Route::get('/books/create', [BookController::class, 'create']);

        /**
         * Menyimpan data buku ke database
         * Method: POST
         */
        Route::post('/books', [BookController::class, 'store']);

        /**
         * Menampilkan form edit buku
         * Route Model Binding:
         * {book} akan otomatis di-convert menjadi object Book
         */
        Route::get('/books/{book}/edit', [BookController::class, 'edit']);

        /**
         * Update data buku
         * Method: PUT
         */
        Route::put('/books/{book}', [BookController::class, 'update']);

        /**
         * Menghapus data buku
         * Method: DELETE
         */
        Route::delete('/books/{book}', [BookController::class, 'destroy']);
    });
});
