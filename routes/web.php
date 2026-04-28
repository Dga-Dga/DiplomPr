<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});

Route::resource('books', BookController::class);

Route::get('books', [BookController::class, 'index'])->name('books.index');