<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected $ImageUrl;
    protected $ImageCover;

    public function __construct() {
        $this->ImageUrl = config('services.store.image');
        // $this->ImageCover = ['cover_01.webp', 'cover_02.webp', 'cover_03.webp', 'cover_04.webp'];
        $this->ImageCover = ['cover.webp'];
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

        return view('home', ['station_from' => $station_from, 'station_to' => $station_to, 'slides' => $slide['data'], 'store' => $this->ImageUrl, 'cover' => $cover]);
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
