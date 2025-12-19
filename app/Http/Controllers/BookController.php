<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // LIST BUKU (ADMIN & USER)
    public function index()
    {
        $books = Book::latest()->get();
        return view('books.index', compact('books'));
    }

    // FORM TAMBAH (ADMIN)
    public function create()
    {
        return view('books.create');
    }

    // SIMPAN DATA (ADMIN)
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'stok' => 'required|integer|min:0',
        ]);

        Book::create($data);

        return redirect('/books');
    }

    // FORM EDIT (ADMIN)
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    // UPDATE DATA (ADMIN)
    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'stok' => 'required|integer|min:0',
        ]);

        $book->update($data);

        return redirect('/books')->with('success', 'Buku berhasil diupdate');
    }

    // HAPUS (ADMIN)
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/books');
    }
}
