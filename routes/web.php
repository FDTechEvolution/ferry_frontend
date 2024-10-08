<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\RouteMapController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\TermAndConditionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\BlogController;

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
    // Route::get('booking', 'search')->name('booking-search');
    // Route::get('booking/view', 'view')->name('booking-view');

    Route::post('booking', 'index')->name('booking-index');
    Route::post('booking/confirm', 'bookingConfirm')->name('booking-confirm');

    Route::post('bookings', 'searchRoundTrip')->name('booking-round-trip');
    Route::post('bookings/confirm', 'bookingRoundConfirm')->name('bookings-confirm');

    Route::post('booking-multi', 'searchMultiTrip')->name('booking-multi');
    Route::post('booking-multi/confirm', 'bookingMultiConfirm')->name('booking-multi-confirm');

    Route::post('booking/view', 'findBookingRecord')->name('booking-record');
    Route::post('ajax/booking/check-booking', 'checkPersonBookingRecord');

    Route::post('booking/book/new', 'bookingNewRoute')->name('booking-new');
    Route::post('booking/update/customer', 'updateCustomer')->name('booking-update-customer');

    Route::get('booking/payment/{booking}/{email}', 'toPayment')->name('booking-payment');
});

Route::controller(TimetableController::class)->group(function() {
    Route::get('time-table', 'index')->name('timetable-index');
});

Route::controller(PageController::class)->group(function() {
    Route::get('page/premium-flex', 'premiumFlex')->name('page.premiumFlex');
});

Route::controller(RouteMapController::class)->group(function() {
    Route::get('route-map', 'index')->name('routemap-index');
});

Route::controller(PaymentController::class)->group(function() {
    Route::get('payment', 'index')->name('payment-index');
    Route::get('payment/print/{bookingno}', 'print')->name('payment-print');
    Route::post('payment/create', 'payment')->name('payment-link');

    // No csrf
    Route::post('payment/ctsv-response', 'paymentCtsvResponse');
});

Route::controller(StationController::class)->group(function() {
    Route::post('ajax/station/to', 'getStationTo');
    Route::get('station', 'index')->name('station-index');
    Route::get('station/detail/{nickname}', 'detail')->name('station-detail');
});

Route::controller(TermAndConditionController::class)->group(function() {
    Route::get('infomation/{type}', 'index')->name('term-index');
});

Route::controller(ReviewController::class)->group(function() {
    Route::get('review', 'index')->name('review-index');
});

Route::controller(PromotionController::class)->group(function() {
    Route::get('promotion/', 'index')->name('promo-index');
    Route::get('promotion/view/{promocode}', 'view')->name('promo-view');

    Route::post('ajax/promotion', 'getPromotion');
});

Route::controller(NewsController::class)->group(function() {
    Route::get('news', 'index')->name('news-index');
    Route::get('news/{slug}', 'view')->name('news-view');
});

Route::controller(BlogController::class)->group(function() {
    Route::get('blog', 'index')->name('blog-index');
    Route::get('blog/{slug}', 'view')->name('blog-view');
});
