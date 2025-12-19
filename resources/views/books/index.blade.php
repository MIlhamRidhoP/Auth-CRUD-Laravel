@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')

{{-- Flash message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Buku</h5>

        @if(auth()->user()->role === 'admin')
            <a href="/books/create" class="btn btn-sm btn-primary">
                + Tambah Buku
            </a>
        @endif
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th width="100">Stok</th>
                    @if(auth()->user()->role === 'admin')
                        <th width="180" class="text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>{{ $book->judul }}</td>
                        <td>{{ $book->penulis }}</td>
                        <td class="text-center">{{ $book->stok }}</td>

                        @if(auth()->user()->role === 'admin')
                        <td class="text-center">
                            {{-- Edit --}}
                            <a href="/books/{{ $book->id }}/edit"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            {{-- Delete --}}
                            <form method="POST"
                                  action="/books/{{ $book->id }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Data buku kosong
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
