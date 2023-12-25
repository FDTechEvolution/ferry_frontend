<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index() {
        $response = Http::reqres()->get('/news');
        $res = $response->json();

        return view('pages.news.index', ['news' => $res['data']]);
    }

    public function view(string $id = null) {
        $response = Http::reqres()->get('/news/get/'.$id);
        $res = $response->json();

        $_news = $this->getNewByView();
        if(isset($res['data'])) {
            return view('pages.news.view', ['news' => $res['data'], '_news' => $_news]);
        }

        return view('404', ['msg' => '']);
    }

    private function getNewByView() {
        $response = Http::reqres()->get('/news/view');
        $res = $response->json();

        return $res['data'];
    }
}
