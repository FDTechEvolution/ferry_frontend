<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected $ImageUrl;
    protected $ImageCover;
    protected $PromoColor;

    public function __construct() {
        $this->ImageUrl = config('services.store.image');
        // $this->ImageCover = ['cover_01.webp', 'cover_02.webp', 'cover_03.webp', 'cover_04.webp'];
        $this->ImageCover = ['cover_v2.webp'];
        $this->PromoColor = ['#FFF59D', '#EEEEEE', '#81D4FA', '#A5D6A7', '#ef9a9a'];
    }

    public function index() {
        $station_route = $this->routeStation();
        $slide = $this->getSlide();
        $cover_index = array_rand($this->ImageCover, 1);
        $cover = $this->ImageCover[$cover_index];
        // $station_from = $this->sectionGroup('section', $station_route['data']['from']);
        $station_to = $this->sectionGroup('section', $station_route['data']['to']);
        $promotions = $this->getPromotion();

        $section_col = $this->sectionColumn($station_route['data']['from']);
        $sections = $this->stationSetTen($section_col);
        // Log::debug($section_col);

        return view('home', ['station_to' => $station_to,
                                'slides' => $slide['data'], 'store' => $this->ImageUrl, 'cover' => $cover,
                                'promotions' => $promotions['data'], 'section_from' => $sections]);
    }

    private function stationSetTen($section_col) {
        $result = [];
        $loop = [];
        $_loop = 0;

        foreach($section_col as $sections) {
            foreach($sections as $key => $stations) {
                $_loop++;
                array_push($loop, ['is_section' => 'Y', 'section' => $key]);
                if($_loop == 10) {
                    array_push($result, $loop);
                    $_loop = 0;
                    $loop = [];
                }
                foreach($stations as $station) {
                    $_loop++;
                    array_push($loop, ['is_section' => 'N', 'station' => $station]);
                    if($_loop == 10) {
                        array_push($result, $loop);
                        $_loop = 0;
                        $loop = [];
                    }
                }
            }
        }

        return $result;
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

    private function getPromotion() {
        $response = Http::reqres()->get('/promotion/get');
        $promotions = $response->json();
        $promo_color = $this->PromoColor;
        $color_length = sizeof($this->PromoColor) -1;
        $color_index = 0;
        foreach($promotions['data'] as $index => $promo) {
            if($color_index > $color_length) $color_index = 0;
            $promotions['data'][$index]['bg_color'] = $promo_color[$color_index];
            $color_index++;
        }

        return $promotions;
    }

    private function getStation() {
        $response = Http::reqres()->get('/stations/get');
        return $response->json();
    }

    private function getSlide() {
        $response = Http::reqres()->get('/slide/get');
        return $response->json();
    }

    private function routeStation() {
        $response = Http::reqres()->get('stations/route');
        return $response->json();
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
