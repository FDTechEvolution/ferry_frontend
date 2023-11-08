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
        $routes = $this->getRouteList($request->from, $request->to);
        $passenger = $this->setInputType($request);
        $_station = ['from' => '', 'to' => ''];
        $booking_date = $request->date;

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

        return view('pages.booking.index', 
            ['isType' => $_type, 'routes' => $routes['data'], 'icon_url' => $this->IconUrl, 
                'is_station' => $_station, 'booking_date' => $booking_date, 'code_country' => $code_country,
                'country_list' => $country_list, 'passenger' => $passenger
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

    private function setInputType($request) {
        if($request->_type == 'round')
            return array($request->round_adult, $request->round_child, $request->round_infant);

        if($request->_type == 'one')
            return array($request->onedepart_adult, $request->onedepart_child, $request->onedepart_infant);
    }

    private function setStation($name, $pier) {
        $piername =  $pier != '' ? ' ('.$pier.')' : '';
        return $name.$piername;
    }

    private function getRouteList($station_from, $station_to) {
        $response = Http::reqres()->get('/route/search/'.$station_from.'/'.$station_to);
        return $response->json();
    }
}
