<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function purchase()
    {
        return view('frontend.purchase');
    }

    public function payfees()
    {
        return view('frontend.payfees');
    }
}
