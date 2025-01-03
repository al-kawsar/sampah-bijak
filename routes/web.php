<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::name('home.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
});

Route::name('auth.')->prefix('auth')->middleware('guest')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login.index');
        Route::post('/login', 'doLogin')->name('login.submit');
    });
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'showRegisterForm')->name('register.index');
        Route::post('/register', 'doRegister')->name('register.submit');
    });
});


Route::name('app.')->middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('App/Dashboard');
    })->name('dashboard');

});