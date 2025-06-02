@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Dashboard Admin</h2>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Buku</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $stats['total_books'] ?? 0 }}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total User</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $stats['total_users'] ?? 0 }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
