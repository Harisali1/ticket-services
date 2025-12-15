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


Route::group(['middleware' => 'auth'], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.dashboard');
        
        Route::prefix('agency')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\AgencyController::class, 'index'])->name('admin.agency.index');
            Route::get('/add', [App\Http\Controllers\Admin\AgencyController::class, 'create'])->name('admin.agency.create');
            Route::post('/store', [App\Http\Controllers\Admin\AgencyController::class, 'store'])->name('admin.agency.store');
            Route::get('/edit/{agency}', [App\Http\Controllers\Admin\AgencyController::class, 'edit'])->name('admin.agency.edit');
            Route::get('/show/{agency}', [App\Http\Controllers\Admin\AgencyController::class, 'show'])->name('admin.agency.show');
            Route::get('/update', [App\Http\Controllers\Admin\AgencyController::class, 'update'])->name('admin.agency.update');
        });

        Route::prefix('airline')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\AirLineController::class, 'index'])->name('admin.airline.index');
            Route::get('/add', [App\Http\Controllers\Admin\AirLineController::class, 'create'])->name('admin.airline.create');
            Route::post('/store', [App\Http\Controllers\Admin\AirLineController::class, 'store'])->name('admin.airline.store');
            Route::get('/edit/{airline}', [App\Http\Controllers\Admin\AirLineController::class, 'edit'])->name('admin.airline.edit');
            // Route::get('/show/{airline}', [App\Http\Controllers\Admin\AirLineController::class, 'edit'])->name('admin.airline.edit');
            Route::get('/update', [App\Http\Controllers\Admin\AirLineController::class, 'update'])->name('admin.airline.update');
        });

        Route::prefix('user')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user.index');
            Route::get('/add', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.user.create');
            Route::post('/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.user.store');
            Route::get('/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.user.edit');
            Route::get('/update', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.user.update');
        });

    });
});

