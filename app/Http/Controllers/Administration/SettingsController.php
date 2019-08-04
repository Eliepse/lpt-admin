<?php


namespace App\Http\Controllers\Administration;


use Illuminate\Routing\Controller;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }
}
