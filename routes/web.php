<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TenantController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

# Show login form
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);

# Logout route
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

# All routes below are protected by auth middleware
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('welcome');
    })->name('dashboard');

    Route::get('/expense', function () {
        return view('expense.index');
    })->name('expense');

    // Resource routes
    Route::resource('booking', BookingController::class);
    Route::resource('apartment', ApartmentController::class);
    Route::resource('tenant', TenantController::class);
});
