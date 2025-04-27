<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;

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


Route::get('/apartment', function(){
    return view('content.apartment');
});
Route::get('/maintenance', function(){
    return view('content.maintenance');
});


Route::get('/tenant', [TenantController::class, 'index'])->name('tenant.index');
Route::get('/tenant/create', function(){
    return view('tenant.create');
});
Route::post('/tenant', [TenantController::class, 'store'])->name('tenants.store');
