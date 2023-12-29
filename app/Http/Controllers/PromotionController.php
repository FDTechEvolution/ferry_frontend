<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PromotionController extends Controller
{
    public function index(){
        $response = Http::reqres()->get('/promotion/get');
        $res = $response->json();
        $store =  config('services.store.image');
        
        return view('pages.promotion.index', ['promotions' => $res['data'],'store' => $store]);
    }

    public function view($promocode) {
        $response = Http::reqres()->get('/promotion/view/'.$promocode);
        $res = $response->json();
        if($res['data']) {
            $store =  config('services.store.image');
            return view('pages.promotion.view', ['promotion' => $res['data'], 'store' => $store]);
        }
        else 
            return view('404', ['msg' => 'No promotion code or promotion code ran out.']);
    }
}
