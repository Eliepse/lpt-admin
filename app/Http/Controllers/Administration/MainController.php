<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function home()
    {
        return view('home');
    }
}
