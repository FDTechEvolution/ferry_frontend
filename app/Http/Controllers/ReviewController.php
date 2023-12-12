<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function index() {
        $response = Http::reqres()->get('review/get');
        $res = $response->json();

        Log::debug($res);

        return view('pages.review.index', ['reviews' => $res['data']]);
    }
}
