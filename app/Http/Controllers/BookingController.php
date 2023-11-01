<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected $IconUrl;
    protected $Type = [
            'one' => 'One way trip',
            'round' => 'Round trip',
            'multi' => 'Multiple'
        ];

    public function __construct() {
        $this->IconUrl = config('services.store.image');
    }

    public function index(Request $request) {
        $routes = null;
        if($request != '') {
            $_type = $request != '' ? $this->Type[$request->_type] : '';
            $routes = $this->getRouteList($request->from, $request->to);
            // Log::debug($routes);

            return view('booking', ['isType' => $_type, 'routes' => $routes['data'], 'icon_url' => $this->IconUrl]);
        }

        return view('booking', ['isType' => '', 'routes' => $routes]);
    }

    private function getRouteList($station_from, $station_to) {
        $response = Http::reqres()->get('/route/search/'.$station_from.'/'.$station_to);
        return $response->json();
    }
}
