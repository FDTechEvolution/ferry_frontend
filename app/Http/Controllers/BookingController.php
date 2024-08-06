<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    protected $IconUrl;
    protected $CodeCountry;
    protected $CountryList;
    protected $Type = [
            'one' => 'One way trip',
            'round' => 'Round trip',
            'multi' => 'Multiple trip'
        ];
    protected $BookingStatus = [
        'DR' => 'Wait PAYMENT',
        'CO' => 'Confirmed',
        'VO' => 'Canceled'
    ];
    protected $RouteAddonIcon = [
        'shuttle_bus' => 'ico-bus.png',
        'private_taxi' => 'ico-private-taxi.png',
        'longtail_boat' => 'ico-long-tail-boat.png'
    ];

    public function __construct() {
        $this->IconUrl = config('services.store.image');
        $this->CodeCountry = config('services.code_country');
        //$this->CodeCountry = json_decode(Storage::disk('public')->get('json/country.json'),true);
        $this->CountryList = config('services.country_list');
    }

    public function index(Request $request) {
        $_type = $this->Type[$request->_type];
        $promocode = null;
        $use_promocode = null;
        $freepremiumflex = 'N';
        // $freecredit = 'N';
        // $freelongtailboat = 'N';
        // $freeshuttlebus = 'N';
        // $freeprivatetaxi = 'N';
        $g_date = $this->setDateToGlobal($request->date[0]);

        $routes = $this->getRouteList($request->from[0], $request->to[0], $g_date);
        if($request->promotioncode != NULL) {
            $use_promocode = $request->promotioncode;
            // promo_code, trip_type, station_from_id, station_to_id, depart_date
            // $promocode = $this->checkPromotionCode($request->promotioncode, 'one-way', $request->from[0], $request->to[0], $request->date[0]);
        }
        $passenger = $this->setInputType($request);
        $_station = ['from' => '', 'to' => ''];
        $booking_date = $request->date[0];

        $_diff = $this->checkDateDiff($booking_date);

        foreach($routes['data'] as $index => $route) {
            if($_station['from'] == '')
                $_station['from'] = $this->setStation($route['station_from']['name'], $route['station_from']['piername']);
            if($_station['to'] == '')
                $_station['to'] = $this->setStation($route['station_to']['name'], $route['station_to']['piername']);

            $_regular_price = intval($this->calPrice($passenger[0], $route['regular_price']));
            $_child_price = intval($this->calPrice($passenger[1], $route['child_price']));
            $_infant_price = intval($this->calPrice($passenger[2], $route['infant_price']));
            $_amount = $_regular_price + $_child_price + $_infant_price;

            $routes['data'][$index]['p_adult'] = $_regular_price;
            $routes['data'][$index]['p_child'] = $_child_price;
            $routes['data'][$index]['p_infant'] = $_infant_price;
            $routes['data'][$index]['amount'] = $_amount;

            $routes['data'][$index]['do_booking'] = $_diff > 0 ? true : $this->checkTimeDiff($route['depart_time']);

            $routes['data'][$index]['travel_time'] = $this->timeTravelDiff($route['depart_time'], $route['arrive_time']);
            $routes['data'][$index]['addon_group'] = $this->sectionGroup('type', $route['route_addons']);

            if($promocode != null) {
                $use_promocode = $request->promotioncode;
                $promo_route = $promocode[1]['route'];
                $promo_from = $promocode[1]['from'];
                $promo_to = $promocode[1]['to'];

                $r = array_search($route['id'], $promo_route);
                $f = array_search($route['station_from_id'], $promo_from);
                $t = array_search($route['station_to_id'], $promo_to);
                $ispromocode = $route['ispromocode'] == 'Y' ? true : false;


                if(empty($promo_route) && empty($promo_from) && empty($promo_to)) {
                    if($ispromocode) {
                        $routes['data'][$index]['promo_price'] = $this->promoDiscount($_amount, $promocode[0]);
                    }
                }
                else {
                    if($r != '' && $ispromocode || $f != '' && $ispromocode || $t != '' && $ispromocode) {
                        $routes['data'][$index]['promo_price'] = $this->promoDiscount($_amount, $promocode[0]);
                    }
                }
            }

            $routes['data'][$index]['station_from']['g_map'] = $this->setGoogleMapPosition($route['station_from']['google_map'])[0];
            $routes['data'][$index]['station_to']['g_map'] = $this->setGoogleMapPosition($route['station_to']['google_map'])[0];
        }

        // if($promocode != null) {
        //     $freecredit = $promocode[0]['isfreecreditcharge'];
        //     $freepremiumflex = $promocode[0]['isfreepremiumflex'];
        //     $freelongtailboat = $promocode[0]['isfreelongtailboat'];
        //     $freeshuttlebus = $promocode[0]['isfreeshuttlebus'];
        //     $freeprivatetaxi = $promocode[0]['isfreeprivatetaxi'];
        // }

        $code_country = $this->CodeCountry;
        $code_country = json_decode(Storage::disk('public')->get('json/country.json'),true);
        $country_list = $this->CountryList;
        $addon_icon = $this->RouteAddonIcon;

        $premium_flex = $this->getPremiumFlex();
        $isNoRoute = $this->routeAvailabel($routes['data']);

        return view('pages.booking.one-way-trip.index',
            ['isType' => $_type, 'routes' => $routes['data'], 'icon_url' => $this->IconUrl,
                'is_station' => $_station, 'booking_date' => $booking_date, 'code_country' => $code_country,
                'country_list' => $country_list, 'passenger' => $passenger, 'promocode' => $use_promocode,
                'addon_icon' => $addon_icon, 'premium_flex' => $premium_flex['data'], 'freepremiumflex' => $freepremiumflex,
                'isNoRoute' => $isNoRoute
            ]);
            // backup
            // 'freecredit' => $freecredit,
            // 'freepremiumflex' => $freepremiumflex,
            // 'freeshuttlebus' => $freeshuttlebus,
            // 'freeprivatetaxi' => $freeprivatetaxi
            // 'freelongtailboat' => $freelongtailboat,

    }

    private function routeAvailabel($routes) {
        $route_count = count($routes);
        $do_booking = 0;
        foreach($routes as $r) {
            if(!$r['do_booking']) $do_booking++;
        }

        return $route_count == $do_booking ? true : false;
    }

    private function setGoogleMapPosition($google_map) {
        if($google_map != '') {
            $g_map = explode(',', str_replace(' ', '', $google_map));
            return array($g_map);
        }

        return array('', '');
    }

    private function promoDiscount($amount, $promo) {
        if($promo['discount_type'] == 'PERCENT') {
            $discount = $amount - ((intval($promo['discount'])/100)*$amount);
            return $discount;
        }

        if($promo['discount_type'] == 'THB') {
            $discount = $amount - intval($promo['discount']);
            return $discount;
        }
    }

    private function getPremiumFlex() {
        $response = Http::reqres()->get('/premium-flex');
        return $response->json();
    }

    private function setDateToGlobal($date) {
        $ex_date = explode('/', $date);
        return $ex_date[2].'-'.$ex_date[1].'-'.$ex_date[0];
    }

    private function checkDateDiff($booking_date) {
        $ex_date = explode('/', $booking_date);
        $date_now = date('Y-m-d');
        $_date_now = date_create($date_now);
        $_date_booking = date_create($ex_date[2].'-'.$ex_date[1].'-'.$ex_date[0]);
        $_date_diff = date_diff($_date_now,$_date_booking);

        return $_date_diff->format('%d');
    }

    private function checkTimeDiff($depart_time) {
        $time_now = date('H:i:s');
        $_time_now = strtotime($time_now);
        $_time_depart = strtotime($depart_time);
        $minute = ($_time_depart - $_time_now) / 60;

        return $minute < 60 ? false : true;
    }

    private function timeTravelDiff($depart, $arrive) {
        $time_depart = strtotime($depart);
        $time_arrive = strtotime($arrive);
        $minute = ($time_arrive - $time_depart) / 60;
        $hour = $minute / 60;
        $set_time = '';

        if(is_float($hour)) {
            $ex = explode('.', $hour);
            $digit = '0.'.$ex[1];
            $to_minute = floatval($digit)*60;

            $setHour = $ex[0].'h ';
            $setMinute = number_format($to_minute, 0, '.', '').'m';

            return $setHour.$setMinute;
        }
        else return $hour.'h 0m';
    }

    public function view(string $id = null) {

        return view('pages.booking.view');
    }

    public function searchRoundTrip(Request $request) {
        $_type = $this->Type[$request->_type];
        $_date = explode(' - ', $request->date[0]);
        $depart_date = $_date[0];
        $return_date = $_date[1];
        $promocode = null;
        $use_promocode = null;
        $freecredit = 'N';
        $freepremiumflex = 'N';

        if($request->promotioncode != NULL) {
            // promo_code, trip_type, station_from_id, station_to_id, depart_date
            // $promocode = $this->checkPromotionCode($request->promotioncode, 'round-trip', $request->from[0], $request->to[0], $request->date[0]);
            $use_promocode = $request->promotioncode;
        }

        $g_depart_date = $this->setDateToGlobal($depart_date);
        $g_return_date = $this->setDateToGlobal($return_date);

        $depart_routes = $this->getRouteList($request->from[0], $request->to[0], $g_depart_date);
        $return_routes = $this->getRouteList($request->to[0], $request->from[0], $g_return_date);
        $passenger = $this->setInputType($request);

        $result_depart = $this->setStationToRoute($depart_routes['data'], $passenger, $depart_date, $promocode);
        $depart_routes = $result_depart[0];
        $station_depart = $result_depart[1];

        $result_return = $this->setStationToRoute($return_routes['data'], $passenger, $return_date, $promocode);
        $return_routes = $result_return[0];
        $station_return = $result_return[1];

        if($g_depart_date == $g_return_date) {
            $_return_routes = [];
            foreach($depart_routes as $depart) {
                $arrive_time = strtotime($depart['arrive_time']);
                foreach($return_routes as $return) {
                    $depart_time = strtotime($depart['depart_time']);
                    if($depart_time >= $arrive_time) {
                        array_push($_return_routes, $return);
                    }
                }
            }
            $return_routes = $_return_routes;
        }

        if($promocode != null) {
            $freecredit = $promocode[0]['isfreecreditcharge'];
            $freepremiumflex = $promocode[0]['isfreepremiumflex'];
        }

        $premium_flex = $this->getPremiumFlex();

        $code_country = json_decode(Storage::disk('public')->get('json/country.json'),true);

        return view('pages.booking.round-trip.index', [
            'isType' => $_type, 'depart_routes' => $depart_routes, 'return_routes' => $return_routes, 'icon_url' => $this->IconUrl,
            'station_depart' => $station_depart, 'station_return' => $station_return, 'depart_date' => $depart_date,
            'return_date' => $return_date, 'passenger' => $passenger, 'code_country' => $code_country, 'country_list' => $this->CountryList,
            'promocode' => $use_promocode, 'freecredit' => $freecredit, 'freepremiumflex' => $freepremiumflex, 'addon_icon' => $this->RouteAddonIcon,
            'premium_flex' => $premium_flex['data'],
        ]);
    }

    public function search() {
        return view('pages.booking.index', ['isType' => '']);
    }

    public function searchMultiTrip(Request $request) {
        $_type = $this->Type[$request->_type];
        $passenger = $this->setInputType($request);
        $route_arr = [];
        $promocode = [];
        $use_promocode = null;
        $freecredit = 'N';
        $freepremiumflex = 'N';
        $r_station = [];

        foreach($request->from as $index => $from) {
            if($from != NULL) {

                if($request->promotioncode != NULL) {
                    // promo_code, trip_type, station_from_id, station_to_id, depart_date
                    // $_promocode = $this->checkPromotionCode($request->promotioncode, 'multi-trip', $from, $request->to[$index], $request['date'][$index]);
                    $use_promocode = $request->promotioncode;
                    // if($_promocode[0] !== null) array_push($promocode, $_promocode);
                    // else array_push($promocode, []);
                }

                $g_date = $this->setDateToGlobal($request['date'][$index]);

                $routes = $this->getRouteList($from, $request->to[$index], $g_date);
                $_diff = $this->checkDateDiff($request['date'][$index]);

                array_push($r_station, $routes['station']);

                foreach($routes['data'] as $key => $route) {
                    $route_arr[$index]['station_from'] = $this->setStation($route['station_from']['name'], $route['station_from']['piername']);
                    $route_arr[$index]['station_to'] = $this->setStation($route['station_to']['name'], $route['station_to']['piername']);
                    $route_arr[$index]['depart'] = $request->date[$index];

                    $_regular_price = intval($this->calPrice($passenger[0], $route['regular_price']));
                    $_child_price = intval($this->calPrice($passenger[1], $route['child_price']));
                    $_infant_price = intval($this->calPrice($passenger[2], $route['infant_price']));
                    $_amount = $_regular_price + $_child_price + $_infant_price;

                    $routes['data'][$key]['p_adult'] = $_regular_price;
                    $routes['data'][$key]['p_child'] = $_child_price;
                    $routes['data'][$key]['p_infant'] = $_infant_price;
                    $routes['data'][$key]['amount'] = $_amount;

                    $routes['data'][$key]['do_booking'] = $_diff > 0 ? true : $this->checkTimeDiff($route['depart_time']);

                    $routes['data'][$key]['travel_time'] = $this->timeTravelDiff($route['depart_time'], $route['arrive_time']);
                    $routes['data'][$key]['addon_group'] = $this->sectionGroup('type', $route['route_addons']);

                    if(!empty($promocode)) {
                        $promo_route = $promocode[$index][1]['route'];
                        $promo_from = $promocode[$index][1]['from'];
                        $promo_to = $promocode[$index][1]['to'];

                        $r = array_search($route['id'], $promo_route);
                        $f = array_search($route['station_from_id'], $promo_from);
                        $t = array_search($route['station_to_id'], $promo_to);
                        $ispromocode = $route['ispromocode'] == 'Y' ? true : false;

                        if(empty($promo_route) && empty($promo_from) && empty($promo_to)) {
                            if($ispromocode) {
                                $routes['data'][$key]['promo_price'] = $this->promoDiscount($_amount, $promocode[$index][0]);
                            }
                        }
                        else {
                            if($r != '' && $ispromocode || $f != '' && $ispromocode || $t != '' && $ispromocode) {
                                $routes['data'][$key]['promo_price'] = $this->promoDiscount($_amount, $promocode[$index][0]);
                            }
                        }
                    }

                    $routes['data'][$key]['station_from']['g_map'] = $this->setGoogleMapPosition($route['station_from']['google_map'])[0];
                    $routes['data'][$key]['station_to']['g_map'] = $this->setGoogleMapPosition($route['station_to']['google_map'])[0];
                }

                $route_arr[$index]['data'] = $routes['data'];
            }
        }

        if(!empty($promocode)) {
            foreach($promocode as $promo) {
                if($promo[0]['isfreecreditcharge'] == 'Y') $freecredit = 'Y';
                if($promo[0]['isfreepremiumflex'] == 'Y') $freepremiumflex = 'Y';
            }
        }

        $premium_flex = $this->getPremiumFlex();
        $code_country = json_decode(Storage::disk('public')->get('json/country.json'),true);
        $route_arr = $this->routeMultiAvailabel($route_arr);

        return view('pages.booking.multi-island.index', ['isType' => $_type, 'route_arr' => $route_arr, 'route_station' => $r_station,
                        'icon_url' => $this->IconUrl, 'passenger' => $passenger, 'code_country' => $code_country,
                        'country_list' => $this->CountryList, 'addon_icon' => $this->RouteAddonIcon, 'promocode' => $use_promocode,
                        'freecredit' => $freecredit, 'freepremiumflex' => $freepremiumflex, 'premium_flex' => $premium_flex['data']]);
    }

    private function routeMultiAvailabel($routes) {
        foreach($routes as $index => $route) {
            $status = $this->routeAvailabel($route['data']);
            $routes[$index]['is_no_route'] = $status;
        }

        return $routes;
    }


    private function checkPromotionCode($promo_code, $trip_type, $station_from_id, $station_to_id, $depart_date) {
        $response = Http::reqres()->post('/promotion/check', [
            'promo_code' => $promo_code,
            'trip_type' => $trip_type,
            'station_from_id' =>$station_from_id,
            'station_to_id' => $station_to_id,
            'depart_date' => $depart_date
        ]);

        $res = $response->json();
        if($res['result']) return array($res['data'], $res['promo_line']);
        return null;
    }

    // One way booking confirm
    public function bookingConfirm(Request $request) {
        $fullname = $this->setPassengerBooking($request->first_name, $request->last_name);
        $passenger = $this->numberOfPassenger($request->passenger_type);
        $_departdate = explode('/', $request->departdate);
        $_birthday = $this->setBirthday($request->birth_day);

        $response = Http::reqres()->post('/online-booking/create', [
            'route_id' => [$request->booking_route_selected],
            'departdate' => $_departdate[2].'-'.$_departdate[1].'-'.$_departdate[0],
            'titlename' => $request->title,
            'fullname' => $fullname,
            'passenger_type' => $request->passenger_type,
            'birth_day' => $_birthday,
            'passenger' => $passenger['adult'],
            'child_passenger' => $passenger['child'],
            'infant_passenger' => $passenger['infant'],
            'mobile_code' => $request->mobile_code,
            'mobile' => $request->mobile,
            'th_mobile' => $request->th_mobile,
            'passportno' => $request->passport_number,
            'country' => $request->country,
            'email' => $request->email,
            'address' => $request->address,
            'meal_id' => [$request->meal_id],
            'meal_qty' => [$request->meal_qty],
            'activity_id' => [$request->activity_id],
            'activity_qty' => [$request->activity_qty],
            'bus_id' => [$request->bus_id],
            'bus_qty' => [$request->bus_qty],
            'boat_id' => [$request->boat_id],
            'boat_qty' => [$request->boat_qty],
            'trip_type' => 'one-way',
            'book_channel' => 'ONLINE',
            'payment_method' => $request->payment_method,
            'ispremiumflex' => $request->ispremiumflex,
            'promocode' => $request->use_promocode,
            'route_addon' => [$request->route_addon_depart],
            'route_addon_detail' => [$request->route_addon_detail_depart]
        ]);

        $res = $response->json();
        if($res['result']) {
            return view('pages.booking.complete', ['bookingno' => $res['booking'], 'email' => $res['email']]);
        }

        return view('404', ['msg' => "Something Wrong. Please See if You've Received Any Emails."]);
    }

    public function toPayment(string $booking = null, string $email = null) {
        if(!is_null($booking) && !is_null($email)) {
            $response = Http::reqres()->get('/online-booking/record/'.$booking.'/'.$email);
            $res = $response->json();
            if($res['result']) {
                $booking = $res['data'];
                $addons = $res['addon'];

                $isPaid = [
                    'N' => '<span class="text-danger fw-bold">Unpaid</span>',
                    'Y' => '<span class="text-success fw-bold">Paid</span>'
                ];

                $payment_lines = $booking['payment'][0]['payment_lines'];
                $customers = $this->setCustomer($res['data']['customer']);
                $station_form = $res['m_from_route'];
                $_station_to = $this->setStationToSection($res['m_route']);
                return view('pages.booking.view',
                            ['booking' => $booking, 'customers' => $customers, 'booking_status' => $this->BookingStatus,
                                'addons' => $addons, 'station_from' => $station_form, 'station_to' => $_station_to[0],
                                'station_to_time' => $_station_to[1], 'icon_url' => $this->IconUrl, 'is_paid' => $isPaid,
                                'payment_lines' => $payment_lines
                            ]);
            }


        }

        return view('404');
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
        $route_id = [$request->booking_depart_selected, $request->booking_return_selected];
        $meal_id = [$request->depart_meal_id, $request->return_meal_id];
        $meal_qty = [$request->depart_meal_qty, $request->return_meal_qty];
        $activity_id = [$request->depart_activity_id, $request->return_activity_id];
        $activity_qty = [$request->depart_activity_qty, $request->return_activity_qty];
        $bus_id = [$request->depart_bus_id, $request->return_bus_id];
        $bus_qty = [$request->depart_bus_qty, $request->return_bus_qty];
        $boat_id = [$request->depart_boat_id, $request->return_boat_id];
        $boat_qty = [$request->depart_boat_qty, $request->return_boat_qty];
        $fullname = $this->setPassengerBooking($request->first_name, $request->last_name);
        $passenger = $this->numberOfPassenger($request->passenger_type);
        $_departdate = explode('/', $request->departdate);
        $_returndate = explode('/', $request->returndate);
        $_birthday = $this->setBirthday($request->birth_day);
        $_route_addon = [$request->route_addon_depart, $request->route_addon_return];
        $_route_addon_detail = [$request->route_addon_detail_depart, $request->route_addon_detail_return];

        $response = Http::reqres()->post('/online-booking/create', [
            'route_id' => $route_id,
            'departdate' => $_departdate[2].'-'.$_departdate[1].'-'.$_departdate[0],
            'returndate' => $_returndate[2].'-'.$_returndate[1].'-'.$_returndate[0],
            'titlename' => $request->title,
            'fullname' => $fullname,
            'passenger_type' => $request->passenger_type,
            'birth_day' => $_birthday,
            'passenger' => $passenger['adult'],
            'child_passenger' => $passenger['child'],
            'infant_passenger' => $passenger['infant'],
            'mobile_code' => $request->mobile_code,
            'mobile' => $request->mobile,
            'th_mobile' => $request->th_mobile,
            'passportno' => $request->passport_number,
            'email' => $request->email,
            'address' => $request->address,
            'country' => $request->country,
            'meal_id' => $meal_id,
            'meal_qty' => $meal_qty,
            'activity_id' => $activity_id,
            'activity_qty' => $activity_qty,
            'bus_id' => $bus_id,
            'bus_qty' => $bus_qty,
            'boat_id' => $boat_id,
            'boat_qty' => $boat_qty,
            'trip_type' => 'round-trip',
            'book_channel' => 'ONLINE',
            'payment_method' => $request->payment_method,
            'ispremiumflex' => $request->ispremiumflex,
            'promocode' => $request->use_promocode,
            'route_addon' => $_route_addon,
            'route_addon_detail' => $_route_addon_detail
        ]);

        $res = $response->json();
        if($res['result']) {
            return view('pages.booking.complete', ['bookingno' => $res['booking'], 'email' => $res['email']]);
        }

        return view('404', ['msg' => "Something Wrong. Please See if You've Received Any Emails."]);
    }

    public function bookingMultiConfirm(Request $request) {
        $fullname = $this->setPassengerBooking($request->first_name, $request->last_name);
        $passenger = $this->numberOfPassenger($request->passenger_type);
        // $depart_date = $request->departdate;
        // $departdate = array_map(function ($depart_date) {
        //     $ex = explode('/', $depart_date);
        //     return  $ex[2].'-'.$ex[1].'-'.$ex[0];
        // }, $depart_date);
        $_birthday = $this->setBirthday($request->birth_day);

        $response = Http::reqres()->post('/online-booking/create/multi', [
            'route_id' => $request->booking_route_selected,
            'departdate' => $request->departdate,
            'titlename' => $request->title,
            'fullname' => $fullname,
            'passenger_type' => $request->passenger_type,
            'birth_day' => $_birthday,
            'passenger' => $passenger['adult'],
            'child_passenger' => $passenger['child'],
            'infant_passenger' => $passenger['infant'],
            'mobile_code' => $request->mobile_code,
            'mobile' => $request->mobile,
            'th_mobile' => $request->th_mobile,
            'passportno' => $request->passport_number,
            'email' => $request->email,
            'address' => $request->address,
            'country' => $request->country,
            'meal_id' => $request->meal_id,
            'meal_qty' => $request->meal_qty,
            'activity_id' => $request->activity_id,
            'activity_qty' => $request->activity_qty,
            'bus_id' => $request->bus_id,
            'bus_qty' => $request->bus_qty,
            'boat_id' => $request->boat_id,
            'boat_qty' => $request->boat_qty,
            'trip_type' => 'multi-trip',
            'book_channel' => 'ONLINE',
            'payment_method' => $request->payment_method,
            'ispremiumflex' => $request->ispremiumflex,
            'route_addon' => $request->route_addon ?? [],
            'route_addon_detail' => $request->route_addon_detail,
            'promocode' => $request->use_promocode
        ]);
        $res = $response->json();
        if($res['result']) {
            return view('pages.booking.complete', ['bookingno' => $res['booking'], 'email' => $res['email']]);
        }

        return view('404', ['msg' => "Something Wrong. Please See if You've Received Any Emails."]);
    }

    private function calPrice($num, $price) {
        return $num*$price;
    }

    private function setInputType($request) {
        if($request->_type == 'round')
            return array($this->setupAdultPassenger($request->roundreturn_adult[0]), $request->roundreturn_child[0], $request->roundreturn_infant[0]);
        if($request->_type == 'one')
            return array($this->setupAdultPassenger($request->onedepart_adult[0]), $request->onedepart_child[0], $request->onedepart_infant[0]);
        if($request->_type == 'multi')
            return array($this->setupAdultPassenger($request->multidepart_adult[0]), $request->multidepart_child[0], $request->multidepart_infant[0]);
    }

    private function setBirthday($birth_day) {
        $b_day = $birth_day;
        $birthday = array_map(function ($b_day) {
            $ex = explode('/', $b_day);
            return  $ex[2].'-'.$ex[1].'-'.$ex[0];
        }, $b_day);

        return $birthday;
    }

    private function setupAdultPassenger($adult) {
        return $adult == 0 ? 1 : $adult;
    }

    private function setStation($name, $pier) {
        $piername =  $pier != '' ? ' ('.$pier.')' : '';
        return $name.$piername;
    }

    private function getRouteList($station_from, $station_to, $date) {
        $response = Http::reqres()->get('/route/search/'.$station_from.'/'.$station_to.'/'.$date);
        return $response->json();
    }

    private function setStationToRoute($routes, $passenger, $booking_date, $promocode) {
        $_routes = $routes;
        $_station = ['from' => '', 'to' => ''];

        $_diff = $this->checkDateDiff($booking_date);

        foreach($_routes as $index => $route) {
            if($_station['from'] == '')
                $_station['from'] = $this->setStation($route['station_from']['name'], $route['station_from']['piername']);
            if($_station['to'] == '')
                $_station['to'] = $this->setStation($route['station_to']['name'], $route['station_to']['piername']);

            $_regular_price = intval($this->calPrice($passenger[0], $route['regular_price']));
            $_child_price = intval($this->calPrice($passenger[1], $route['child_price']));
            $_infant_price = intval($this->calPrice($passenger[2], $route['infant_price']));
            $_amount = $_regular_price + $_child_price + $_infant_price;

            $_routes[$index]['p_adult'] = $_regular_price;
            $_routes[$index]['p_child'] = $_child_price;
            $_routes[$index]['p_infant'] = $_infant_price;
            $_routes[$index]['amount'] = $_amount;

            $_routes[$index]['do_booking'] = $_diff > 0 ? true : $this->checkTimeDiff($route['depart_time']);

            $_routes[$index]['travel_time'] = $this->timeTravelDiff($route['depart_time'], $route['arrive_time']);
            $_routes[$index]['addon_group'] = $this->sectionGroup('type', $route['route_addons']);

            if($promocode != null) {
                $promo_route = $promocode[1]['route'];
                $promo_from = $promocode[1]['from'];
                $promo_to = $promocode[1]['to'];

                $r = array_search($route['id'], $promo_route);
                $f = array_search($route['station_from_id'], $promo_from);
                $t = array_search($route['station_to_id'], $promo_to);
                $ispromotion = $route['ispromocode'] == 'Y' ? true : false;

                if(empty($promo_route) && empty($promo_from) && empty($promo_to)) {
                    if($ispromotion) {
                        $_routes[$index]['promo_price'] = $this->promoDiscount($_amount, $promocode[0]);
                    }
                }
                else {
                    if($r != '' && $ispromotion || $f != '' && $ispromotion || $t != '' && $ispromotion) {
                        $_routes[$index]['promo_price'] = $this->promoDiscount($_amount, $promocode[0]);
                    }
                }
            }

            $_routes[$index]['station_from']['g_map'] = $this->setGoogleMapPosition($route['station_from']['google_map'])[0];
            $_routes[$index]['station_to']['g_map'] = $this->setGoogleMapPosition($route['station_to']['google_map'])[0];
        }

        return array($_routes, $_station);
    }

    public function findBookingRecord(Request $request) {
        $_booking_number = (isset($request->booking_number) && $request->booking_number != '') ? true : false;
        $_booking_email = (isset($request->booking_email) && $request->booking_email != '') ? true : false;
        $msg = '';
        if($_booking_number && $_booking_email) {
            if(isset($request->booking_number_new)) {
                $this->mergeBooking($request);
            }
            $response = Http::reqres()->get('/online-booking/record/'.$request->booking_number.'/'.$request->booking_email);
            $res = $response->json();
            if($res['result']) {
                $booking = $res['data'];
                $addons = $res['addon'];

                $isPaid = [
                    'N' => '<span class="text-danger fw-bold">Unpaid</span>',
                    'Y' => '<span class="text-success fw-bold">Paid</span>'
                ];

                $payment_lines = $booking['payment'][0]['payment_lines'];
                $customers = $this->setCustomer($res['data']['customer']);
                $station_form = $res['m_from_route'];
                $_station_to = $this->setStationToSection($res['m_route']);
                $route_addon = $booking['extra_addons'][0]['addons'];
                $passengers = ['adult' => $booking['adult'], 'child' => $booking['child'], 'infant' => $booking['infant']];
                $passenger = $booking['adult'] + $booking['child'] + $booking['infant'];
                // $longtail_boat = $this->separateRouteAddon($addons['route_addons'], 'longtail_boat');
                // $shuttle_bus = $this->separateRouteAddon($addons['route_addons'], 'shuttle_bus');
                $payment_lines = $this->setNewPaymentLines($payment_lines, $booking['booking_number']);
                $trip_type = $this->setTripType($booking['trip_type'], $booking['route']);
                $route_payment_lines = $this->setSummaryDiscount($payment_lines, 'ROUTE');
                $premium_payment_lines = $this->setSummaryDiscount($payment_lines, 'PREMIUM');
                $addon_payment_lines = $this->setSummaryDiscount($payment_lines, 'ADDON');
                $fee_payment_lines = $this->setSummaryDiscount($payment_lines, 'FEE');

                // Log::debug($booking);
                $fee = $this->getFeeSetting($passengers, $booking);

                return view('pages.booking.view',
                            ['booking' => $booking, 'customers' => $customers, 'booking_status' => $this->BookingStatus,
                                'addons' => $addons, 'station_from' => $station_form, 'station_to' => $_station_to[0],
                                'station_to_time' => $_station_to[1], 'icon_url' => $this->IconUrl, 'is_paid' => $isPaid,
                                'payment_lines' => $payment_lines, 'route_addon' => $route_addon, 'passenger' => $passenger,
                                'passengers' => $passengers, 'trip_type' => $trip_type, 'route_payments' => $route_payment_lines,
                                'premium_payments' => $premium_payment_lines, 'addon_payments' => $addon_payment_lines,
                                'passenger_email' => $request->booking_email, 'fee_payments' => $fee_payment_lines, 'fee' => $fee
                            ]);
            }

            $msg = $res['data'];
        }

        return view('404', ['msg' => $msg]);
    }

    private function getFeeSetting($passengers, $booking) {
        $response = Http::reqres()->get('/fee-manage');
        $res = $response->json();

        $fee = $res['data'];
        $_f = [];

        // Log::debug($fee);

        foreach($fee as $f) {
            $type = $f['type'];
            $_f[$type]['type'] = $f['type'];
            $_f[$type]['total'] = 0;
            $_f[$type]['isuse_pf'] = 'N';
            $_f[$type]['isuse_sc'] = 'N';
            if($f['isuse_pf'] == 'Y') {
                if($f['is_pf_perperson'] == 'Y') {
                    $_f[$type]['adult'] = $f['regular_pf'];
                    $_f[$type]['adult_fee'] = $passengers['adult'] * $f['regular_pf'];
                    $_f[$type]['child'] = $f['child_pf'];
                    $_f[$type]['child_fee'] = $passengers['child'] * $f['child_pf'];
                    $_f[$type]['infant'] = $f['infant_pf'];
                    $_f[$type]['infant_fee'] = $passengers['infant'] * $f['infant_pf'];
                    $_f[$type]['total'] += $_f[$type]['adult_fee'] + $_f[$type]['child_fee'] + $_f[$type]['infant_fee'];
                }
                else {
                    $total = $booking['payment'][0]['totalamt']*($f['percent_pf']/100);
                    $_f[$type]['percent'] = $f['percent_pf'];
                    $_f[$type]['total'] += $total;
                }
                $_f[$type]['isuse_pf'] = 'Y';
            }

            if($f['isuse_sc'] == 'Y') {
                if($f['is_sc_perperson'] == 'Y') {
                    $_f[$type]['adult'] = $f['regular_sc'];
                    $_f[$type]['adult_fee'] = $passengers['adult'] * $f['regular_sc'];
                    $_f[$type]['child'] = $f['child_sc'];
                    $_f[$type]['child_fee'] = $passengers['child'] * $f['child_sc'];
                    $_f[$type]['infant'] = $f['infant_sc'];
                    $_f[$type]['infant_fee'] = $passengers['infant'] * $f['infant_sc'];
                    $_f[$type]['total'] += $_f[$type]['adult_fee'] + $_f[$type]['child_fee'] + $_f[$type]['infant_fee'];
                }
                else {
                    $total = $booking['payment'][0]['totalamt']*($f['percent_sc']/100);
                    $_f[$type]['percent'] = $f['percent_sc'];
                    $_f[$type]['total'] += $total;
                }
                $_f[$type]['isuse_sc'] = 'Y';
            }
        }

        // Log::debug($_f);
        return $_f;
    }

    private function setTripType($trip_type, $route) {
        if($trip_type == 'one-way') return ['One Way Trip'];
        if($trip_type == 'round-trip') return ['Round Trip', 'Return'];
        if($trip_type == 'multi-trip') {
            $trip = [];
            for($i = 0; $i < count($route); $i++) array_push($trip, 'Trip '.$i+1);
            return $trip;
        }
    }

    private function setSummaryDiscount($lines, $type) {
        $_lines = [];
        foreach($lines as $line) if($line['type'] == $type) array_push($_lines, $line);
        return $_lines;
    }

    private function setNewPaymentLines($payment_line, $bookingno) {
        $order = ['ROUTE', 'PREMIUM', 'ADDON'];
        foreach($payment_line as $index => $line) {
            if(strpos($line['title'], $bookingno)) {
                $ex = explode(',', $line['title']);
                $payment_line[$index]['title'] = $ex[1];
            }
        }

        usort($payment_line, function ($a, $b) use ($order) {
            $pos_a = array_search($a['type'], $order);
            $pos_b = array_search($b['type'], $order);
            return $pos_a - $pos_b;
        });

        return $payment_line;
    }

    private function separateRouteAddon($addons, $type) {
        $result = [
            'from' => [],
            'to' => []
        ];
        foreach($addons as $item) {
            if($item['type'] == $type) {
                if($item['subtype'] == 'from') array_push($result['from'], $item);
                if($item['subtype'] == 'to') array_push($result['to'], $item);
            }
        }

        return $result;
    }

    public function bookingNewRoute(Request $request) {
        Http::reqres()->post('/online-booking/add-new-route', [
            'booking_id' => $request->booking_id,
            'route_id' => $request->to,
            'depart' => $request->depart_date,
            'return' => $request->return_date
        ]);

        return view('pages.payment.updated', ['message' => 'Updated...', 'bookingno' => $request->bookingno]);
    }

    private function setStationToSection($to_route) {
        $routes = [];
        $routes_sub = [];
        foreach($to_route as $index => $to) {
            $name = $to['station_to']['name'];
            $pier = $to['station_to']['piername'] != null ? ' ('.$to['station_to']['piername'].')' : '';
            $depart = $to['depart_time'];
            $arrive = $to['arrive_time'];
            $station = $name.$pier;

            $to_arr = [
                'id' => $to['station_to']['id'],
                'name' => $station,
                'section' => $to['station_to']['section']['name']
            ];

            if(!in_array($to_arr, $routes)) {
                array_push($routes, $to_arr);
            }

            $routes_sub[$to['station_to']['id']][] = ['id' => $to['id'], 'station_name' => $station, 'station_id' => $to['station_to']['id'], 'depart' => $depart, 'arrive' => $arrive];
        }

        $section = $this->sectionGroup('section', $routes);
        return array($section, $routes_sub);
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

    public function checkPersonBookingRecord(Request $request) {
        if(isset($request->booking_current) && $request->booking_number != '') {
            $response = Http::reqres()->get('/online-booking/check/person/'.$request->booking_current.'/'.$request->booking_number);
            $res = $response->json();

            return response()->json(['data' => $res], 200);
        }
    }

    private function setCustomer($res) {
        $customers = [];
        foreach($res as $cus) {
            $customers[$cus['type']][] = $cus;
        }

        return $customers;
    }

    private function setRoute($res) {
        $station_to = [];
        foreach($res as $r) {
            $name = $r['station_to']['name'];
            $pier = $r['station_to']['piername'] != null ? ' ('.$r['station_to']['piername'].')' : '';
            $depart = $r['depart_time'];
            $arrive = $r['arrive_time'];
            $station = $name.$pier.' ['.$this->setTime($depart).' - '.$this->setTime($arrive).']';
            array_push($station_to, ['id' => $r['id'], 'name' => $station]);
        }

        return $station_to;
    }

    private function setTime($time) {
        return date_format(date_create($time), 'H:i');
    }

    private function mergeBooking(Request $request) {
        $response = Http::reqres()->post('/online-booking/merge/', [
                        'booking_number' => $request->booking_number,
                        'booking_number_new' => $request->booking_number_new
                    ]);
        $res = $response->json();

        return view('pages.payment.updated', ['message' => 'Updated...', 'bookingno' => $request->booking_number]);
    }

    public function updateCustomer(Request $request) {
        Http::reqres()->post('/customer/update', [
            'fullname' => $request->fullname,
            'date' => $request->date,
            'email' => $request->email,
            'cus_id' => $request->cus_id
        ]);

        return view('pages.payment.updated', ['message' => 'Updated...', 'bookingno' => $request->bookingno]);
    }
}
