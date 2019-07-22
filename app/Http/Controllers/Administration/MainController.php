<?php

namespace App\Http\Controllers\Administration;

use App\Office;
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
        $offices = Office::all();

        return view('home', compact('offices'));
    }
}
