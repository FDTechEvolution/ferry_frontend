<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TermAndConditionController extends Controller
{
    public function index() {
        $response = Http::reqres()->get('term-and-condition/get');
        $res = $response->json();

        return view('pages.termandcondition.index', ['data' => $res['data']['body']]);
    }
}
