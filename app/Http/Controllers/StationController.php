<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StationController extends Controller
{
    protected $ImageUrl;

    public function __construct() {
        $this->ImageUrl = config('services.store.image');
    }

    public function getStationTo(Request $request) {
        $response = Http::reqres()->get('stations/get/to/'.$request->station_id);
        $res = $response->json();
        // $result = $this->sectionGroup('section', $res['data']['to']);
        // Log::debug($result);
        $_result = $res['data']['to'];
        $_section = $this->sectionColumn($res['data']['to']);
        $sections = $this->stationSetTen($_section);

        return response()->json(['data' => $_result, 'section' => $sections], 200);
    }

    private function stationSetTen($section_col) {
        $result = [];
        $loop = [];
        $_loop = 0;

        foreach($section_col as $sections) {
            foreach($sections as $key => $stations) {
                // $_loop++;
                array_push($loop, ['is_section' => 'Y', 'section' => $key]);
                // if($_loop == 10) {
                //     array_push($result, $loop);
                //     $_loop = 0;
                //     $loop = [];
                // }
                foreach($stations as $station) {
                    // $_loop++;
                    array_push($loop, ['is_section' => 'N', 'station' => $station]);
                    // if($_loop == 10) {
                    //     array_push($result, $loop);
                    //     $_loop = 0;
                    //     $loop = [];
                    // }
                }
            }
        }

        if(count($result) <= 0) return array($loop);
        else return $result;
    }

    private function sectionColumn($stations) {
        $result = [];
        $result2 = [];

        foreach($stations as $val) {
            if(array_key_exists('s_sort', $val)){
                $result[$val['s_sort']][] = $val;
            }else{
                $result[""][] = $val;
            }
        }

        foreach($result as $key => $item) {
            foreach($item as $value) {
                if(array_key_exists('section', $value)){
                    $result2[$key][$value['section']][] = $value;
                }else{
                    $result2[$key][""][] = $value;
                }
            }
        }

        ksort($result2);

        foreach($result2 as $key => $res) {
            foreach($res as $index => $r) {
                usort($result2[$key][$index], function ($a, $b) {return $a['sort'] > $b['sort'];});
            }
        }

        return $result2;
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

    public function index() {
        // $response = Http::reqres()->get('stations/route');
        // $res =  $response->json();

        // $all_routes = $this->arrayMerge($res['data']['from'], $res['data']['to']);
        // $route_uniq = array_unique($all_routes, SORT_REGULAR);
        // $route_sort = $this->arraySortA($route_uniq, 'name');
        // Log::debug($route_sort);
        // $image_station = ['cover_01.webp', 'cover_02.webp', 'cover_03.webp', 'cover_04.webp'];
        // $station_to = $this->sectionGroup('section', $res['data']['to']);

        $response2 = Http::reqres()->get('stations/get/type');
        $res2 = $response2->json();
        $stations = $this->group_by('type', $res2['data']);
        $stations = $this->orderCustom($stations);

        return view('pages.station.index', ['stations' => $stations, 'store' => $this->ImageUrl]);
    }

    private function orderCustom($array) {
        $order = ['island' => [], 'pier' => [], 'airport' => [], 'hotel' => [], 'other' => []];

        foreach($order as $ord => $o) {
            foreach($array as $index => $arr) {
                if($ord == $index) $order[$ord] = $array[$index];
            }
        }

        return $order;
    }

    private function group_by($key, $data) {
        $result = array();

        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }

        return $result;
    }

    private function arrayMerge($arr_1, $arr_2) {
        return array_merge($arr_1, $arr_2);
    }

    private function arraySortA($array, $sortBy) {
        $by = [];
        foreach($array as $key => $arr) { $by[$key] = $arr[$sortBy]; }
        array_multisort($by, SORT_ASC, $array);
        return $array;
    }

    public function detail($nickname){
        //$nickname = request()->code;
        $response = Http::reqres()->get('stations/get/nickname/'.$nickname);
        $res =  $response->json();

        return view('pages.station.detail', ['station'=>$res,'store' => $this->ImageUrl]);
    }
}
