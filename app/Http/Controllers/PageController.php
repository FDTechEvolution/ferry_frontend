<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function premiumFlex(){

        return view('pages.premium_flex');
    }

}
