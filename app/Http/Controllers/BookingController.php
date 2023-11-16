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

        return view('pages.booking.one-way-trip.index', 
            ['isType' => $_type, 'routes' => $routes['data'], 'icon_url' => $this->IconUrl, 
                'is_station' => $_station, 'booking_date' => $booking_date, 'code_country' => $code_country,
                'country_list' => $country_list, 'passenger' => $passenger
            ]);
    }

    public function view(string $id = null) {

        return view('pages.booking.view');
    }

    public function searchRoundTrip(Request $request) {
        $_type = $this->Type[$request->_type];
        $_date = explode(' - ', $request->date[0]);
        $depart_date = $_date[0];
        $return_date = $_date[1];

        $depart_routes = $this->getRouteList($request->from[0], $request->to[0]);
        $return_routes = $this->getRouteList($request->to[0], $request->from[0]);
        $passenger = $this->setInputType($request);

        $result_depart = $this->setStationToRoute($depart_routes['data'], $passenger);
        $depart_routes = $result_depart[0];
        $station_depart = $result_depart[1];

        $result_return = $this->setStationToRoute($return_routes['data'], $passenger);
        $return_routes = $result_return[0];
        $station_return = $result_return[1];

        return view('pages.booking.round-trip.index', [
            'isType' => $_type, 'depart_routes' => $depart_routes, 'return_routes' => $return_routes, 'icon_url' => $this->IconUrl,
            'station_depart' => $station_depart, 'station_return' => $station_return, 'depart_date' => $depart_date, 
            'return_date' => $return_date, 'passenger' => $passenger, 'code_country' => $this->CodeCountry, 'country_list' => $this->CountryList
        ]);
    }

    public function search() {
        return view('pages.booking.index', ['isType' => '']);
    }

    // One way booking confirm
    public function bookingConfirm(Request $request) {
        $fullname = $this->setPassengerBooking($request->first_name, $request->last_name);
        $passenger = $this->numberOfPassenger($request->passenger_type);
        $_departdate = explode('/', $request->departdate);

        $response = Http::reqres()->post('/booking/create', [
            'route_id' => $request->booking_route_selected,
            'departdate' => $_departdate[2].'-'.$_departdate[1].'-'.$_departdate[0],
            'fullname' => $fullname,
            'passenger_type' => $request->passenger_type,
            'passenger' => $passenger['adult'],
            'child_passenger' => $passenger['child'],
            'infant_passenger' => $passenger['infant'],
            'mobile' => $request->mobile,
            'passportno' => $request->passport_number,
            'email' => $request->email,
            'address' => $request->address,
            'meal_id' => $request->meal_id,
            'meal_qty' => $request->meal_qty,
            'activity_id' => $request->activity_id,
            'activity_qty' => $request->activity_qty,
            'trip_type' => 'one-way',
            'book_channel' => 'ONLINE'
        ]);
        $res = $response->json();

        return redirect()->route('booking-view', ['id' => $res['data']]);
    }

    private function setPassengerBooking($first_name, $last_name) {
        $fullname = [];
        foreach($first_name as $key => $f_name) { array_push($fullname, $f_name.' '.$last_name[$key]); }
        return $fullname;
    }

    private function numberOfPassenger($passenger_type) {
        $_passenger = ['adult' => 0, 'child' => 0, 'infant' => 0];
        foreach($passenger_type as $type) {
            if($type == 'Adult') $_passenger['adult']++;
            if($type == 'Child') $_passenger['child']++;
            if($type == 'Infant') $_passenger['infant']++;
        }
        return $_passenger;
    }

    // Round trip booking confirm
    public function bookingRoundConfirm(Request $request) {
        // $_depart = $this->roundTripBooking(
        //                     $request, 
        //                     $request->booking_depart_selected, 
        //                     $request->depart_meal_id,
        //                     $request->depart_meal_qty,
        //                     $request->depart_activity_id,
        //                     $request->depart_activity_qty,
        //                     $request->depart_date
        //                 );
        // $_return = $this->roundTripBooking(
        //                     $request, 
        //                     $request->booking_return_selected, 
        //                     $request->return_meal_id,
        //                     $request->return_meal_qty,
        //                     $request->return_activity_id,
        //                     $request->return_activity_qty,
        //                     $request->return_date
        //                 );

        // Log::debug($_depart);
        // Log::debug($_return);

        Log::debug($request);
        return redirect()->route('home');
    }

    private function roundTripBooking($request, $route_id, $meal_id, $meal_qty, $activity_id, $activity_qty, $date) {
        $fullname = $this->setPassengerBooking($request->first_name, $request->last_name);
        $passenger = $this->numberOfPassenger($request->passenger_type);
        $_date = explode('/', $date);

        $response = Http::reqres()->post('/booking/create', [
            'route_id' => $route_id,
            'departdate' => $_date[2].'-'.$_date[1].'-'.$_date[0],
            'fullname' => $fullname,
            'passenger_type' => $request->passenger_type,
            'passenger' => $passenger['adult'],
            'child_passenger' => $passenger['child'],
            'infant_passenger' => $passenger['infant'],
            'mobile' => $request->mobile,
            'passportno' => $request->passport_number,
            'email' => $request->email,
            'address' => $request->address,
            'meal_id' => $meal_id,
            'meal_qty' => $meal_qty,
            'activity_id' => $activity_id,
            'activity_qty' => $activity_qty,
            'trip_type' => 'round-trip',
            'book_channel' => 'ONLINE'
        ]);
        $res = $response->json();

        return $res;
    }

    private function calPrice($num, $price) {
        return $num*$price;
    }

    private function setInputType($request) {
        if($request->_type == 'round')
            return array($request->roundreturn_adult[0], $request->roundreturn_child[0], $request->roundreturn_infant[0]);
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
