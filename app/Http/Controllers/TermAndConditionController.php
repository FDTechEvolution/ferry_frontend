<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TermAndConditionController extends Controller
{
    public function index(string $type = null) {
        $response = Http::reqres()->get('infomation/get/'.$type);
        $res = $response->json();

        if($res['result'])
            return view('pages.termandcondition.index', ['data' => $res['data']]);
        else
            return view('404', ['msg' => "Page Not Found."]);
    }
}
