<?php


namespace Eliepse\Charts\HeatWeekCalendar;


use App\Enums\DaysEnum;
use stdClass;

class HeatWeekCalendar
{
    /**
     * Represent the stats interval in minutes
     *
     * @var int
     */
    private $granularity;

    /**
     * Day "start at" values
     *
     * @var int
     */
    private $dayStartAt;

    /**
     * Day "start at" values
     *
     * @var int
     */
    private $dayEndAt;

    /**
     * @var int
     */
    private $levels;

    /**
     * @var array
     */
    private $data = [];


    /**
     * HeatWeekCalendar constructor.
     *
     * @param int $granularity In minutes
     * @param int $startAt In minutes
     * @param int $endAt In minutes
     * @param int $levels
     */
    public function __construct(int $granularity = 60, int $startAt = 8 * 60, int $endAt = 20 * 60, int $levels = 3)
    {
        $this->granularity = $granularity;
        $this->dayStartAt = $startAt;
        $this->dayEndAt = $endAt;
        $this->levels = $levels;

        for ($h = $startAt; $h < $endAt; $h += $granularity) {
            $this->data[ $h ] = new HeatRow();
        }
    }


    /**
     * @param string $day
     * @param int $startAt in minutes from midnight
     * @param int $duration in minutes
     *
     * @return $this
     */
    public function add(string $day, int $startAt, int $duration = 60): self
    {
        $day = DaysEnum::getValue($day) - 1;

        // we first define which steps it has to increment
        $delta = $startAt % $this->granularity;
        $start = max($this->dayStartAt, $startAt - $delta);
//        $end = min($this->dayEndAt, $start + $duration - ($duration % $this->granularity));

        for ($h = 0; $h < ceil($duration / $this->granularity); $h++) {
            $hour = $start + ($this->granularity * $h);
            $this->data[ $hour ]->add($day);
        }

        return $this;
    }


    private function getMin(): int
    {
        $notEmptyRows = array_filter($this->data, function (HeatRow $hr) { return $hr->getMin() > 0; });

        if (empty($notEmptyRows)) {
            return 1;
        }

        return min(array_map(function (HeatRow $hr) { return $hr->getMin(); }, $notEmptyRows));
    }


    private function getMax(): int
    {
        return max(array_map(function (HeatRow $hr) { return $hr->getMax(); }, $this->data));
    }


    public function getData(): array
    {
        ksort($this->data);

        $min = $this->getMin();
        $max = $this->getMax();

        return array_map(function (HeatRow $hr) use ($min, $max) {
            return array_map(function (HeatCell $hc) use ($min, $max) {
                return $hc->computeLevel($this->levels, $min, $max);
            }, $hr->getDays());
        }, $this->data);
    }
}
