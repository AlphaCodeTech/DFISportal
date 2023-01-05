<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

   
}
