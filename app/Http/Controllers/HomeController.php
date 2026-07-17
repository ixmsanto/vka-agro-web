<?php

namespace App\Http\Controllers;

use App\Support\SiteContent;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $content = SiteContent::all();

        return view('site.home', [
            'hero' => $content['hero'],
            'video' => $content['video'],
            'contact' => $content['contact'],
            'products' => $content['products'],
            'gallery' => $content['gallery'],
            'testimonials' => $content['testimonials'],
            'posts' => $content['posts'],
        ]);
    }
}
