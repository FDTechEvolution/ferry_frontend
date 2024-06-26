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
        $promotions = $this->setColorToPromotion($res['data']);

        return view('pages.promotion.index', ['promotions' => $promotions, 'store' => $store]);
    }

    private function setColorToPromotion($promo) {
        $promo_font_color = ['#ddc704', '#706d6d', '#2297cd', '#2cab31', '#bd2828'];

        $promotions = $promo;
        $color_length = sizeof($promo_font_color) -1;
        $color_index = 0;
        $result = [];
        foreach($promotions as $index => $promo) {
            if($promo['code'] != 'Cg4z8qUMS') {
                if($color_index > $color_length) $color_index = 0;
                $promo['color'] = $promo_font_color[$color_index];
                array_push($result, $promo);
                // $promotions[$index]['color'] = $promo_font_color[$color_index];

                $color_index++;
            }
        }

        return $result;
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

    public function getPromotion(Request $request) {
        $_date = str_replace('/', '-', $request->depart_date);
        $response = Http::reqres()->get('/promotion/check-v2/'.$request->promocode.'/'.$_date.'/'.$request->trip_type);
        $res = $response->json();

        return response()->json(['result' => true, 'data' => $res], 200);
    }
}
