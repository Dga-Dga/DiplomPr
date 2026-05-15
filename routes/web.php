<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;



Route::get('/', [BookController::class, 'index'])->name('books.index');

Route::resource('books', BookController::class);

Route::get('books', [BookController::class, 'index'])->name('books.index');

///
///
///
///маршруты для регистрации и авториз
///
///
///

// Регистрация
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Вход и выход
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Страницы, доступные только админам
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return 'Панель администратора';
    })->name('admin.dashboard');
});

// Страницы для админов и менеджеров
Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::get('/manager', function () {
        return 'Панель менеджера';
    })->name('manager.dashboard');
});

//защита от посторонних бабуинов


Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{book}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{book}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});