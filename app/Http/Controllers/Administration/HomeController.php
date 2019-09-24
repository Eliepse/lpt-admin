<?php

namespace App\Http\Controllers\Administration;

use App\Office;
use App\Schedule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    /**
     * Represent the stats interval in hours
     *
     * @var int
     */
    private $statsGranularity = .5;

    /**
     * Day "start at" and "end at" values
     *
     * @var array
     */
    private $dayBoundaries = [8, 20];

    /**
     * @var int
     */
    private $activityLevels = 3;


    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function __invoke()
    {
        $offices = Office::with(['schedules.course.lessons'])->get();

        $stats = $offices
            ->keyBy('id')
            ->map(function (Office $office) {
                return $this->officeActivityStats($office);
            });

//        dd($stats);

        return view('home', ['offices' => $offices, 'stats' => $stats]);
    }


    private function officeActivityStats(Office $office): Collection
    {
        $hoursStats = collect();
        $min = 0;
        $max = $this->activityLevels - 1;

        for ($h = $this->dayBoundaries[0]; $h <= $this->dayBoundaries[1]; $h += $this->statsGranularity) {

            $hourStats = $office
                ->activeSchedules
                ->filter(function (Schedule $schedule) use ($h) {
                    $end_at = $schedule->hour->hour + ($schedule->duration / 60);

                    return $schedule->hour->hour <= $h && $end_at >= $h + $this->statsGranularity;
                })
                ->groupBy('day')
                ->map(function (Collection $day) use (&$min, &$max) {
                    $count = $day->count();

                    $min = $min === 0 ? $count : min($min, $count);
                    $max = max($max, $count);

                    return $count;
                });

            $hoursStats->put($h, $hourStats);
        }

        $levelsDelta = max(1, ($max - $min) / $this->activityLevels);

        // We change to levels of activity to show off the most active periods
        $hoursStats->transform(function (Collection $hours) use ($min, $max, $levelsDelta) {
            return $hours->map(function (int $count) use ($min, $max, $levelsDelta) {
                for ($level = $this->activityLevels - 1; $level > 0; $level--) {
                    if ($count >= $min + ($level * $levelsDelta)) {
                        return $level;
                    }
                }

                return 0;
            });
        });

        return $hoursStats;
    }


    private function scheduleStatsByHour(Office $office): Collection
    {
        return $office->activeSchedules
            ->groupBy(function (Schedule $schedule) { return $schedule->hour->hour; })
            ->sortKeys()
            ->map(function (Collection $hour) {
                return $hour
                    ->groupBy('day')
                    ->map(function (Collection $hour) {
                        return ceil($hour->max('duration') / 60);
                    });
            });
    }
}
