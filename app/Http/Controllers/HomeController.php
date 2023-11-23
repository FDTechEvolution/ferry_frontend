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
        $this->ImageCover = ['cover_01.webp', 'cover_02.webp', 'cover_03.webp', 'cover_04.webp'];
    }

    public function index() {
        $stations = $this->getStation();
        $slide = $this->getSlide();
        $cover_index = array_rand($this->ImageCover, 1);
        $cover = $this->ImageCover[$cover_index];

        return view('home', ['stations' => $stations['data'], 'slides' => $slide['data'], 'store' => $this->ImageUrl, 'cover' => $cover]);
    }

    private function getStation() {
        $response = Http::reqres()->get('/stations/get');
        return $response->json();
    }

    private function getSlide() {
        $response = Http::reqres()->get('/slide/get');
        return $response->json();
    }
}
