<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TimetableController extends Controller
{
    protected $ImageUrl;

    public function __construct() {
        $this->ImageUrl = config('services.store.image');
    }

    public function index() {
        $tt = $this->getTimetable();

        $id = request()->id;
        $timeTables = $tt['data'];
        $default = sizeof($timeTables)==0?[]:$timeTables[0];

        if(!empty($id)){
            foreach($timeTables as $item){
                if($id == $item['id']){
                    $default = $item;
                    break;
                }
            }
        }

        return view('pages.timetable.index', ['timetable' =>$timeTables, 'img_url' => $this->ImageUrl,'default'=>$default]);
    }

    private function getTimetable() {
        $response = Http::reqres()->get('/time-table/get');
        $res = $response->json();

        return $res;
    }
}
