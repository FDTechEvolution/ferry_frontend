<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\RouteMapController;

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
    Route::get('booking/view/{id}', 'view')->name('booking-view');
    
    Route::post('booking', 'index')->name('booking-index');
    Route::post('booking/confirm', 'bookingConfirm')->name('booking-confirm');

    Route::post('bookings', 'searchRoundTrip')->name('booking-round-trip');
    Route::post('bookings/confirm', 'bookingRoundConfirm')->name('bookings-confirm');
});

Route::controller(TimetableController::class)->group(function() {
    Route::get('time-table', 'index')->name('timetable-index');
});

Route::controller(RouteMapController::class)->group(function() {
    Route::get('route-map', 'index')->name('routemap-index');
});