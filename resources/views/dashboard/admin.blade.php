@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow text-center">
            <div class="card-body">
                <h3 class="mb-3">Dashboard Admin</h3>

                <p>
                    Halo, <strong>{{ auth()->user()->name }}</strong>
                </p>

                <span class="badge bg-danger mb-3">
                    Role: Admin
                </span>

                <div class="mt-4">
                    <a href="/books" class="btn btn-primary">
                        Kelola Buku
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
