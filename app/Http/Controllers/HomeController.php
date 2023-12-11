<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected $ImageUrl;
    protected $ImageCover;
    protected $PromoColor;

    public function __construct() {
        $this->ImageUrl = config('services.store.image');
        // $this->ImageCover = ['cover_01.webp', 'cover_02.webp', 'cover_03.webp', 'cover_04.webp'];
        $this->ImageCover = ['cover.webp'];
        $this->PromoColor = ['#fdf21c', '#d9d9d9', '#18aded', '#169448', '#f5060f'];
    }

    public function index() {
        $stations = $this->getStation();
        $station_route = $this->routeStation();
        // Log::debug($station_route);
        $slide = $this->getSlide();
        $cover_index = array_rand($this->ImageCover, 1);
        $cover = $this->ImageCover[$cover_index];
        $station_from = $this->sectionGroup('section', $station_route['data']['from']);
        $station_to = $this->sectionGroup('section', $station_route['data']['to']);
        $promotions = $this->getPromotion();

        return view('home', ['station_from' => $station_from, 'station_to' => $station_to, 
                                'slides' => $slide['data'], 'store' => $this->ImageUrl, 'cover' => $cover,
                                'promotions' => $promotions['data']]);
    }

    private function getPromotion() {
        $response = Http::reqres()->get('/promotion/get');
        $promotions = $response->json();
        $promo_color = $this->PromoColor;
        $color_length = sizeof($this->PromoColor) -1;
        $color_index = 0;
        foreach($promotions['data'] as $index => $promo) {
            if($color_index > $color_length) $color_index = 0;
            $promotions['data'][$index]['bg_color'] = $promo_color[$color_index];
            $color_index++;
        }

        return $promotions;
    }

    private function getStation() {
        $response = Http::reqres()->get('/stations/get');
        return $response->json();
    }

    private function getSlide() {
        $response = Http::reqres()->get('/slide/get');
        return $response->json();
    }

    private function routeStation() {
        $response = Http::reqres()->get('stations/route');
        return $response->json();
    }

    private function sectionGroup($key, $stations) {
        $result = [];

        foreach($stations as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }

        return $result;
    }
}
