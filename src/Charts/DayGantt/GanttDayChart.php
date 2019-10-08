<?php


namespace Eliepse\Charts\DayGantt;


use App\Schedule;
use Illuminate\Support\Collection;

class GanttDayChart
{
    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $end;

    /**
     * @var Collection
     */
    private $schedules;


    /**
     * DayGanttSchedule constructor.
     *
     * @param int $start Set the gantt start hour (in minutes)
     * @param int $end Set the gantt end hour (in minutes)
     */
    public function __construct(int $start = 8 * 60, int $end = 18 * 60)
    {
        $this->start = $start;
        $this->end = $end;
        $this->schedules = collect();
    }


    /**
     * @param bool $inHour If true, the output will be the hour without the minutes (floor)
     *
     * @return int
     */
    public function getStart(bool $inHour = false): int
    {
        return $inHour ? floor($this->start / 60) : $this->start;
    }


    /**
     * @param bool $inHour If true, the output will be the hour without the minutes (floor)
     *
     * @return int
     */
    public function getEnd(bool $inHour = false): int
    {
        return $inHour ? floor($this->end) / 60 : $this->end;
    }


    /**
     * @param bool $inHour If true, the output will be in hour without the minutes (floor)
     *
     * @return int
     */
    public function getDuration(bool $inHour = false): int
    {
        return $inHour ? floor(($this->end - $this->start) / 60) : $this->end - $this->start;
    }


    public function add(Schedule $schedule): self
    {
        $this->schedules->push($schedule);

        return $this;
    }


    public function getData(): Collection
    {
        return $this->schedules
            ->sortBy(function (Schedule $s) {
                return $this->getScheduleStart($s) . '-' . $s->duration;
            });
    }


    /**
     * Take an hour and determine it's position (in percentage) in the gantt chart
     *
     * @param int $hour
     *
     * @return float
     */
    public function hourToPercent(int $hour): float
    {
        return bound(round(($hour - $this->start) / $this->getDuration(), 4) * 100, 0, 100);
    }


    public function durationToPercent(int $minutes): float
    {
        return max(round($minutes / $this->getDuration(), 4) * 100, 0);
    }


    /**
     * Return in minute the schedule's starting hour
     *
     * @param Schedule $schedule
     * @param bool $percent
     *
     * @return int
     */
    public function getScheduleStart(Schedule $schedule, bool $percent = false): int
    {
        $start = ($schedule->hour->hour * 60) + $schedule->hour->minute;

        return $percent ? $this->hourToPercent($start) : $start;
    }


    /**
     * Return in minute the schedule's ending hour
     *
     * @param Schedule $schedule
     * @param bool $percent
     *
     * @return int
     */
    public function getScheduleEnd(Schedule $schedule, bool $percent = false): int
    {
        $end = $this->getScheduleStart($schedule) + $schedule->duration;

        return $percent ? $this->hourToPercent($end) : $end;
    }
}
