<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index(Request $request) {
        Log::debug($request);

        return redirect()->route('home');
    }
}
