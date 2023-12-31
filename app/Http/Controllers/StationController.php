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
        // Log::debug($_section);

        return response()->json(['data' => $_result, 'section' => $_section], 200);
    }

    private function sectionColumn($stations) {
        $result = [];
        $result2 = [];

        foreach($stations as $val) {
            if(array_key_exists('col', $val)){
                $result[$val['col']][] = $val;
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
        $response = Http::reqres()->get('stations/route');
        $res =  $response->json();

        $image_station = ['cover_01.webp', 'cover_02.webp', 'cover_03.webp', 'cover_04.webp'];
        $station_to = $this->sectionGroup('section', $res['data']['to']);
        // Log::debug($station_to);

        return view('pages.station.index', ['section' => $station_to, 'image_station' => $image_station]);
    }

    public function detail($nickname){
        //$nickname = request()->code;
        $response = Http::reqres()->get('stations/get/nickname/'.$nickname);
        $res =  $response->json();

        return view('pages.station.detail', ['station'=>$res,'store' => $this->ImageUrl]);
    }
}
