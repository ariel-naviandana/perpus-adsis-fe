<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookManagementController;
use App\Http\Controllers\UserManagementController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    $userRole = session('user_role');

    if ($userRole) {
        switch ($userRole) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'petugas':
                return redirect()->route('manage.books');
            case 'siswa':
            default:
                return redirect()->route('user.home');
        }
    }

    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Siswa only
Route::middleware(RoleMiddleware::class . ':siswa')->group(function () {
    Route::get('/home', [BookController::class, 'userHome'])->name('user.home');
    Route::get('/books/download/{id}', [BookController::class, 'download'])->name('books.download');
});

// Admin & Petugas: manage buku
Route::middleware(RoleMiddleware::class . ':admin-petugas')->group(function () {
    Route::get('/manage/books', [BookManagementController::class, 'index'])->name('manage.books');
    Route::post('/manage/books', [BookManagementController::class, 'store'])->name('manage.books.store');
    Route::put('/manage/books/{id}', [BookManagementController::class, 'update'])->name('manage.books.update');
    Route::delete('/manage/books/{id}', [BookManagementController::class, 'destroy'])->name('manage.books.destroy');
    Route::get('/manage/books/{id}', [BookManagementController::class, 'show'])->name('manage.books.show');
});

// Admin only
Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/manage/users', [UserManagementController::class, 'index'])->name('manage.users');
    Route::post('/manage/users', [UserManagementController::class, 'store'])->name('manage.users.store');
    Route::put('/manage/users/{id}', [UserManagementController::class, 'update'])->name('manage.users.update');
    Route::delete('/manage/users/{id}', [UserManagementController::class, 'destroy'])->name('manage.users.destroy');
});
