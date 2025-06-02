<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Perpustakaan Digital')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Perpustakaan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        @auth
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                @if(auth()->user()->role === 'user')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Daftar Buku</a>
                    </li>
                @elseif(auth()->user()->role === 'petugas')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('books.manage') }}">Manajemen Buku</a>
                    </li>
                @elseif(auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('books.manage') }}">Manajemen Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.manage') }}">Manajemen User</a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <span class="nav-link">{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link" style="display:inline; cursor:pointer;">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        @endauth
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
