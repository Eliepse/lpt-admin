<?php

namespace App\Http\Controllers\Administration;

use App\Campus;
use App\Enums\DaysEnum;
use App\Schedule;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function __invoke()
    {
        $today = DaysEnum::getKey(Carbon::today()->dayOfWeek);
        $activeSchedules = Schedule::query()
            ->with([
                'campus:id,name',
                'course:id,name',
                'course.lessons:lesson_id',
                'subscriptions:id,marketable_id,marketable_type,student_id,paid,price',
                'subscriptions.student:id,firstname,lastname',
            ])
            ->whereRaw('start_at <= NOW()')
            ->whereRaw('end_at >= NOW()')
            ->orderBy('hour')
            ->get();

        $subscriptions = $activeSchedules
            ->pluck('subscriptions')
            ->flatten(1);

        return view('home', [
            'todaySchedules' => $activeSchedules->where('day', $today)->groupBy('campus_id'),
            'subscriptions' => $subscriptions,
            'unpaidSubs' => $subscriptions->filter(function (Subscription $s) { return !$s->isPaid(); }),
        ]);
    }
}
