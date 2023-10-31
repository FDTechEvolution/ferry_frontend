<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected $API = 'http://127.0.0.1:8080/api/v2';
    protected $Store = 'http://127.0.0.1:8080';

    public function index() {
        $stations = $this->getStation();
        $slide = $this->getSlide();

        return view('home', ['stations' => $stations['data'], 'slides' => $slide['data'], 'store' => $this->Store]);
    }

    private function getStation() {
        $response = Http::get($this->API.'/stations/get');
        return $response->json();
    }

    private function getSlide() {
        $response = Http::get($this->API.'/slide/get');
        return $response->json();
    }
}
