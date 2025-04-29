<?php

use App\Http\Controllers\ApartmentController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use App\Models\Apartment;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/findme', function(){
    return view('Me.findme');
});
Route::get('/booking', function(){
    return view('content.booking');
});

Route::get('/maintenance', function(){
    return view('content.maintenance');
});

Route::get('/apartment', [ApartmentController::class, 'index'])->name('apartment.index');
Route::get('/apartment/create', [ApartmentController::class, 'create'])->name('apartments.create');
Route::resource('tenant', TenantController::class);
