<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //La route ménant à la page home.blade.php
    public function home()
    {
        return view('home.home');
    }

    //La route ménant à la page home.blade.php
    public function about()
    {
        return view('home.about');
    }

    //La route ménant à la page dashboard.blade.php
    public function dashboard()
    {
        return view('home.dashboard');
    }

}