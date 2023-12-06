<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StationController extends Controller
{
    public function getStationTo(Request $request) {
        $response = Http::reqres()->get('stations/get/to/'.$request->station_id);
        $res = $response->json();
        // $result = $this->sectionGroup('section', $res['data']['to']);
        // Log::debug($result);
        $_result = $res['data']['to'];
        
        return response()->json(['data' => $_result], 200);
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
}
