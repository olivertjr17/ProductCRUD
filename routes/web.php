<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('layouts.app');
});

Auth::routes();

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
});

Route::get('/auth-check', [ProductController::class, 'checkAuthentication']);

Route::get('{any}', function () {
    return view('layouts.app');
})->where('any', '.*');
