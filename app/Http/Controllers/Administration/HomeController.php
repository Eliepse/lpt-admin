<?php

namespace App\Http\Controllers\Administration;

use App\Campus;
use App\Enums\DaysEnum;
use App\Schedule;
use Carbon\Carbon;
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
        $schedules = Schedule::query()
            ->with(['campus:id,name', 'course:id,name', 'course.lessons:lesson_id'])
            ->where('day', DaysEnum::getKey(Carbon::today()->dayOfWeek))
            ->orderBy('hour')
            ->get()
            ->groupBy('campus_id');

        return view('home', ['todaySchedules' => $schedules]);
    }
}
