<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contacts', [
            'title' => 'page title',
            'text' => 'page content',
        ]);
    }
}
