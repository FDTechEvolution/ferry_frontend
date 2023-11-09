<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected $IconUrl;
    protected $CodeCountry;
    protected $CountryList;
    protected $Type = [
            'one' => 'One way trip',
            'round' => 'Round trip',
            'multi' => 'Multiple'
        ];

    public function __construct() {
        $this->IconUrl = config('services.store.image');
        $this->CodeCountry = config('services.code_country');
        $this->CountryList = config('services.country_list');
    }

    public function index(Request $request) {
        $_type = $this->Type[$request->_type];
        $routes = $this->getRouteList($request->from[0], $request->to[0]);
        $passenger = $this->setInputType($request);
        $_station = ['from' => '', 'to' => ''];
        $booking_date = $request->date[0];

        // Log::debug($request);

        foreach($routes['data'] as $index => $route) {
            if($_station['from'] == '') 
                $_station['from'] = $this->setStation($route['station_from']['name'], $route['station_from']['piername']);
            if($_station['to'] == '')
                $_station['to'] = $_station_from = $this->setStation($route['station_to']['name'], $route['station_to']['piername']);

            $routes['data'][$index]['p_adult'] = intval($this->calPrice($passenger[0], $route['regular_price']));
            $routes['data'][$index]['p_child'] = intval($this->calPrice($passenger[1], $route['child_price']));
            $routes['data'][$index]['p_infant'] = intval($this->calPrice($passenger[2], $route['infant_price']));
        }

        $code_country = $this->CodeCountry;
        $country_list = $this->CountryList;
        // Log::debug($passenger);

        return view('pages.booking.one-way-trip.index', 
            ['isType' => $_type, 'routes' => $routes['data'], 'icon_url' => $this->IconUrl, 
                'is_station' => $_station, 'booking_date' => $booking_date, 'code_country' => $code_country,
                'country_list' => $country_list, 'passenger' => $passenger
            ]);
    }

    public function searchRoundTrip(Request $request) {
        // Log::debug($request);
        $_type = $this->Type[$request->_type];
        $depart_date = $request->date[0];
        $return_date = $request->date[1];

        $depart_routes = $this->getRouteList($request->from[0], $request->to[0]);
        $return_routes = $this->getRouteList($request->from[1], $request->to[1]);
        $passenger_depart = $this->setInputType($request, 'depart');
        $passenger_return = $this->setInputType($request, 'return');

        $result_depart = $this->setStationToRoute($depart_routes['data'], $passenger_depart);
        $depart_routes = $result_depart[0];
        $station_depart = $result_depart[1];

        $result_return = $this->setStationToRoute($return_routes['data'], $passenger_return);
        $return_routes = $result_return[0];
        $station_return = $result_return[1];

        return view('pages.booking.round-trip.index', [
            'isType' => $_type, 'depart_routes' => $depart_routes, 'return_routes' => $return_routes, 'icon_url' => $this->IconUrl,
            'station_depart' => $station_depart, 'station_return' => $station_return, 'depart_date' => $depart_date, 
            'return_date' => $return_date, 'passenger_depart' => $passenger_depart, 'passenger_return' => $passenger_return, 
            'code_country' => $this->CodeCountry, 'country_list' => $this->CountryList
        ]);
    }

    public function search() {
        return view('pages.booking.index', ['isType' => '']);
    }

    public function bookingConfirm(Request $request) {
        Log::debug($request);

        return redirect()->route('home');
    }

    private function calPrice($num, $price) {
        return $num*$price;
    }

    private function setInputType($request, $route_type = null) {
        if($request->_type == 'round') {
            if($route_type == 'depart')
                return array($request->rounddepart_adult[0], $request->rounddepart_child[0], $request->rounddepart_infant[0]);
            else if($route_type == 'return')
                return array($request->roundreturn_adult[0], $request->roundreturn_child[0], $request->roundreturn_infant[0]);
        }

        if($request->_type == 'one')
            return array($request->onedepart_adult[0], $request->onedepart_child[0], $request->onedepart_infant[0]);
    }

    private function setStation($name, $pier) {
        $piername =  $pier != '' ? ' ('.$pier.')' : '';
        return $name.$piername;
    }

    private function getRouteList($station_from, $station_to) {
        $response = Http::reqres()->get('/route/search/'.$station_from.'/'.$station_to);
        return $response->json();
    }

    private function setStationToRoute($routes, $passenger) {
        $_routes = $routes;
        $_station = ['from' => '', 'to' => ''];
        foreach($_routes as $index => $route) {
            if($_station['from'] == '') 
                $_station['from'] = $this->setStation($route['station_from']['name'], $route['station_from']['piername']);
            if($_station['to'] == '')
                $_station['to'] = $_station_from = $this->setStation($route['station_to']['name'], $route['station_to']['piername']);

            $_routes[$index]['p_adult'] = intval($this->calPrice($passenger[0], $route['regular_price']));
            $_routes[$index]['p_child'] = intval($this->calPrice($passenger[1], $route['child_price']));
            $_routes[$index]['p_infant'] = intval($this->calPrice($passenger[2], $route['infant_price']));
        }

        return array($_routes, $_station);
    }
}
