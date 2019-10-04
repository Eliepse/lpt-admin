<?php

namespace App\Http\Controllers\Administration;

use App\Campus;
use App\Schedule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function __invoke()
    {
        return view('home');
    }
}
