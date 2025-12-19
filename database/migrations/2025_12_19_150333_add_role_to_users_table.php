<?php
// Menandakan bahwa file ini adalah file PHP
// Wajib ada di baris paling atas

use Illuminate\Database\Migrations\Migration;
// Class dasar untuk semua migration di Laravel

use Illuminate\Database\Schema\Blueprint;
// Digunakan untuk mendefinisikan struktur kolom tabel

use Illuminate\Support\Facades\Schema;
// Facade Schema digunakan untuk membuat / mengubah tabel database

// Laravel 8+ menggunakan anonymous class untuk migration
// Artinya migration ini adalah satu class tanpa nama
return new class extends Migration
{
    /**
     * Method up()
     * ----------------
     * Akan dijalankan saat perintah:
     * php artisan migrate
     */
    public function up(): void
    {
        // Schema::table digunakan untuk MEMODIFIKASI tabel yang sudah ada
        // Dalam kasus ini: tabel 'users'
        Schema::table('users', function (Blueprint $table) {

            // Menambahkan kolom baru bernama 'role'
            // Tipe data: string (varchar)
            // default('user') → jika user baru dibuat, role otomatis 'user'
            // after('password') → posisi kolom setelah kolom password
            $table->string('role')->default('user')->after('password');
        });
    }

    /**
     * Method down()
     * ----------------
     * Akan dijalankan saat perintah:
     * php artisan migrate:rollback
     * 
     * Idealnya, method ini digunakan untuk
     * mengembalikan kondisi database seperti semula
     */
    public function down(): void
    {
        // Schema::table digunakan kembali untuk memodifikasi tabel users
        Schema::table('users', function (Blueprint $table) {

            // Menghapus kolom 'role'
            // Ini kebalikan dari method up()
            $table->dropColumn('role');

            // Catatan:
            // Jika method ini dikosongkan, rollback tetap jalan
            // tapi kolom 'role' tidak akan dihapus
        });
    }
};
