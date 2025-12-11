<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/agency', [App\Http\Controllers\Admin\AgencyController::class, 'index'])->name('admin.agency.index');
Route::get('/agency/add', [App\Http\Controllers\Admin\AgencyController::class, 'create'])->name('admin.agency.create');
