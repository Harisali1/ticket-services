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

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/custom/livewire/update', $handle);
});

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('public/livewire/update', $handle);
});

Route::get('search/airport', [App\Http\Controllers\Admin\DataListController::class, 'searchAirport'])->name('search.airport');
Route::get('search/airline', [App\Http\Controllers\Admin\DataListController::class, 'searchAirLine'])->name('search.airline');
Route::get('search/baggage', [App\Http\Controllers\Admin\DataListController::class, 'searchBaggage'])->name('search.baggage');


Route::group(['middleware' => 'auth'], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.dashboard');
        
        Route::prefix('agency')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\AgencyController::class, 'index'])->name('admin.agency.index');
            Route::get('/add', [App\Http\Controllers\Admin\AgencyController::class, 'create'])->name('admin.agency.create');
            Route::post('/store', [App\Http\Controllers\Admin\AgencyController::class, 'store'])->name('admin.agency.store');
            Route::get('/edit/{agency}', [App\Http\Controllers\Admin\AgencyController::class, 'edit'])->name('admin.agency.edit');
            Route::get('/show/{agency}', [App\Http\Controllers\Admin\AgencyController::class, 'show'])->name('admin.agency.show');
            Route::post('/update', [App\Http\Controllers\Admin\AgencyController::class, 'update'])->name('admin.agency.update');
        });

        Route::prefix('airline')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\AirLineController::class, 'index'])->name('admin.airline.index');
            Route::get('/add', [App\Http\Controllers\Admin\AirLineController::class, 'create'])->name('admin.airline.create');
            Route::post('/store', [App\Http\Controllers\Admin\AirLineController::class, 'store'])->name('admin.airline.store');
            Route::get('/edit/{airline}', [App\Http\Controllers\Admin\AirLineController::class, 'edit'])->name('admin.airline.edit');
            Route::post('/update', [App\Http\Controllers\Admin\AirLineController::class, 'update'])->name('admin.airline.update');
        });

        Route::prefix('airport')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\AirportController::class, 'index'])->name('admin.airport.index');
            Route::get('/add', [App\Http\Controllers\Admin\AirportController::class, 'create'])->name('admin.airport.create');
            Route::post('/store', [App\Http\Controllers\Admin\AirportController::class, 'store'])->name('admin.airport.store');
            Route::get('/edit/{airport}', [App\Http\Controllers\Admin\AirportController::class, 'edit'])->name('admin.airport.edit');
            Route::post('/update', [App\Http\Controllers\Admin\AirportController::class, 'update'])->name('admin.airport.update');
        });

        Route::prefix('user')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user.index');
            Route::get('/add', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.user.create');
            Route::post('/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.user.store');
            Route::get('/edit/{user}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.user.edit');
            Route::post('/update', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.user.update');
        });

        Route::prefix('pnr')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\PnrController::class, 'index'])->name('admin.pnr.index');
            Route::get('/add', [App\Http\Controllers\Admin\PnrController::class, 'create'])->name('admin.pnr.create');
            Route::post('/store', [App\Http\Controllers\Admin\PnrController::class, 'store'])->name('admin.pnr.store');
            Route::get('/edit', [App\Http\Controllers\Admin\PnrController::class, 'edit'])->name('admin.pnr.edit');
            Route::get('/update', [App\Http\Controllers\Admin\PnrController::class, 'update'])->name('admin.pnr.update');
            Route::get('/upload', [App\Http\Controllers\Admin\PnrController::class, 'uploadPnr'])->name('admin.pnr.upload');
            Route::post('/upload', [App\Http\Controllers\Admin\PnrController::class, 'uploadPnrSubmit'])->name('admin.pnr.upload.submit');
            Route::prefix('seats')->group(function () {
                Route::post('/store', [App\Http\Controllers\Admin\PnrController::class, 'seatStore'])->name('admin.pnr.seats.store');
                Route::post('/cancel', [App\Http\Controllers\Admin\PnrController::class, 'seatCancel'])->name('admin.pnr.seats.cancel');
            });
        });

        Route::prefix('booking')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('admin.booking.index');
            Route::get('/add', [App\Http\Controllers\Admin\BookingController::class, 'create'])->name('admin.booking.create');
            Route::post('/add', [App\Http\Controllers\Admin\BookingController::class, 'create'])->name('admin.booking.create');
            Route::post('/create', [App\Http\Controllers\Admin\BookingController::class, 'getPnrInfo'])->name('admin.booking.pnr.info');
            Route::post('/check_seats_availablity', [App\Http\Controllers\Admin\BookingController::class, 'checkSeatsAvailability'])->name('admin.booking.seats.availability');
            Route::post('/booking_submit', [App\Http\Controllers\Admin\BookingController::class, 'bookingSubmit'])->name('admin.booking.submit');
            // Route::get('/edit/{user}', [App\Http\Controllers\Admin\BookingController::class, 'edit'])->name('admin.booking.edit');
            // Route::post('/update', [App\Http\Controllers\Admin\BookingController::class, 'update'])->name('admin.booking.update');
        });

        Route::prefix('bank')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\BankController::class, 'index'])->name('admin.bank.index');
            Route::get('/add', [App\Http\Controllers\Admin\BankController::class, 'create'])->name('admin.bank.create');
            Route::post('/store', [App\Http\Controllers\Admin\BankController::class, 'store'])->name('admin.bank.store');
            Route::get('/edit/{bank}', [App\Http\Controllers\Admin\BankController::class, 'edit'])->name('admin.bank.edit');
            Route::post('/update', [App\Http\Controllers\Admin\BankController::class, 'update'])->name('admin.bank.update');
        });

        Route::prefix('baggage')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\BaggageController::class, 'index'])->name('admin.baggage.index');
            Route::get('/add', [App\Http\Controllers\Admin\BaggageController::class, 'create'])->name('admin.baggage.create');
            Route::post('/store', [App\Http\Controllers\Admin\BaggageController::class, 'store'])->name('admin.baggage.store');
            Route::get('/edit/{baggage}', [App\Http\Controllers\Admin\BaggageController::class, 'edit'])->name('admin.baggage.edit');
            Route::post('/update', [App\Http\Controllers\Admin\BaggageController::class, 'update'])->name('admin.baggage.update');
        });
    });
});

