<?php
// Menandakan bahwa file ini adalah file PHP
// Wajib ada di baris pertama

namespace App\Models;
// Namespace menunjukkan lokasi class ini berada
// Semua model default Laravel ada di App\Models

use Illuminate\Database\Eloquent\Factories\HasFactory;
// Trait ini digunakan untuk keperluan factory (testing / seeder)

use Illuminate\Database\Eloquent\Model;
// Class dasar Eloquent Model
// Semua model database di Laravel harus extend Model

class Book extends Model
{
    // Menggunakan trait HasFactory
    // Memungkinkan model Book menggunakan factory
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini
     * -----------------------------------------
     * Sebenarnya OPSIONAL karena Laravel otomatis
     * mengubah nama class Book → tabel books
     * 
     * Tapi ditulis agar lebih jelas & eksplisit
     */
    protected $table = 'books';

    /**
     * Kolom yang boleh diisi secara mass assignment
     * ---------------------------------------------
     * Digunakan saat:
     * Book::create([...])
     * $book->update([...])
     * 
     * Tanpa $fillable → akan terjadi MassAssignmentException
     */
    protected $fillable = [
        'judul',    // Judul buku
        'penulis',  // Nama penulis
        'stok',     // Jumlah stok buku
    ];
}
