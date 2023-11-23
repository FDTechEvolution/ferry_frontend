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

        return view('pages.timetable.index', ['timetable' => $tt['data'], 'img_url' => $this->ImageUrl]);
    }

    private function getTimetable() {
        $response = Http::reqres()->get('/time-table/get');
        $res = $response->json();

        return $res;
    }
}
