@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">
                <h5>Tambah Buku</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="/books">
                    @csrf

                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Penulis</label>
                        <input type="text" name="penulis" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" min="0" required>
                    </div>

                    <button class="btn btn-success">Simpan</button>
                    <a href="/books" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
