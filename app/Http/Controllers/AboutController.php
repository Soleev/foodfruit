<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        return view('about', [
        'title' => 'page title',
            'text' => 'page content',
        ]);
    }
}
