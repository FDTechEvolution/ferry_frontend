<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::controller(BookingController::class)->group(function() {
    Route::get('booking', 'search')->name('booking-search');
    
    Route::post('booking', 'index')->name('booking-index');
    Route::post('booking/confirm', 'bookingConfirm')->name('booking-confirm');

    Route::post('bookings', 'searchRoundTrip')->name('booking-round-trip');
    Route::post('bookings/confirm', 'bookingRoundConfirm')->name('bookings-confirm');
});