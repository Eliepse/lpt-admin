<?php

namespace App\Http\Controllers\Administration;

use App\Enums\DaysEnum;
use App\Schedule;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function __invoke()
    {
        $today = DaysEnum::getKey(Carbon::today()->dayOfWeekIso);
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
            'activeSchedules' => $activeSchedules,
            'todaySchedules' => $activeSchedules->where('day', $today),
            'subscriptions' => $subscriptions,
            'unpaidSubs' => $subscriptions->filter(function (Subscription $sub) { return !$sub->isPaid(); }),
        ]);
    }
}
