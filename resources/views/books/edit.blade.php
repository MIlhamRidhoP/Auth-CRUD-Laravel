@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">
                <h5>Edit Buku</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="/books/{{ $book->id }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text"
                               name="judul"
                               class="form-control"
                               value="{{ old('judul', $book->judul) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label>Penulis</label>
                        <input type="text"
                               name="penulis"
                               class="form-control"
                               value="{{ old('penulis', $book->penulis) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label>Stok</label>
                        <input type="number"
                               name="stok"
                               class="form-control"
                               value="{{ old('stok', $book->stok) }}"
                               min="0"
                               required>
                    </div>

                    <button class="btn btn-primary">Update</button>
                    <a href="/books" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
