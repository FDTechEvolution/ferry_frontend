<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    protected $ImageUrl;

    public function __construct() {
        $this->ImageUrl = config('services.store.image');
    }

    public function index() {
        $blog = $this->getBlogs();
        $first_blog = $blog['data'][0];
        $second_blog = $blog['data'][1];
        $third_blog = $blog['data'][2];

        return view('pages.blog.index', ['blog' => $blog['data'], 'store' => $this->ImageUrl,
                                        'first_blog' => $first_blog, 'second_blog' => $second_blog, 'third_blog' => $third_blog]);
    }

    public function view(string $slug = null) {
        $blog = $this->getBlogBySlug($slug);

        if($blog['result'])
            return view('pages.blog.view', ['blog' => $blog['data'], 'store' => $this->ImageUrl]);
        else
            return view('404', ['msg' => "Page Not Found."]);
    }

    private function getBlogs() {
        $response = Http::reqres()->get('/blog/get');
        return $response->json();
    }

    private function getBlogBySlug($slug) {
        $response = Http::reqres()->get('/blog/get-blog/'.$slug);
        return $response->json();
    }
}
