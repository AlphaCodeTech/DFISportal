<?php

namespace App\Http\Controllers;

use App\Models\User;

class HomeController extends Controller
{
    public function index(User $user)
    {
        dd($user);
        return view('frontend.index');
    }

    public function purchase()
    {
        return view('frontend.purchase');
    }

   
}
