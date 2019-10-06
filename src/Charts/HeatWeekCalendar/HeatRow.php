<?php


namespace Eliepse\Charts\HeatWeekCalendar;


class HeatRow
{
    /**
     * @var array
     */
    private $days = [];


    /**
     * HeatHour constructor.
     */
    public function __construct()
    {
        // We fill our days array
        for ($d = 0; $d < 7; $d++) {
            $this->days[ $d ] = new HeatCell();
        }
    }


    public function getDays(): array
    {
        return $this->days;
    }


    public function add(int $day, int $amount = 1): self
    {
        $this->findOrCreateDay($day)
            ->increment($amount);

        return $this;
    }


    private function findOrCreateDay(int $day): HeatCell
    {
        if (!isset($this->days[ $day ])) {
            $this->days[ $day ] = new HeatCell();
        }

        return $this->days[ $day ];
    }


    public function getMin(): int
    {
        $notEmptyCell = array_filter($this->days, function (HeatCell $hc) { return $hc->getAmount() > 0; });

        if (empty($notEmptyCell)) {
            return 0;
        }

        return min(array_map(function (HeatCell $hc) { return $hc->getAmount(); }, $notEmptyCell));
    }


    public function getMax(): int
    {
        return max(array_map(function (HeatCell $hc) { return $hc->getAmount(); }, $this->days));
    }
}
