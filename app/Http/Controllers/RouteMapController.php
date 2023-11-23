<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RouteMapController extends Controller
{
    protected $ImageUrl;

    public function __construct() {
        $this->ImageUrl = config('services.store.image');
    }

    public function index() {
        $rm = $this->getRouteMap();

        return view('pages.routemap.index', ['routemap' => $rm['data'], 'img_url' => $this->ImageUrl]);
    }

    private function getRouteMap() {
        $response = Http::reqres()->get('/route-map/get');
        $res = $response->json();

        return $res;
    }
}
