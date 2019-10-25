<?php


namespace Eliepse\Charts\HeatWeekCalendar;


class HeatCell
{
    private $amount = 0;


    public function increment(int $amount = 1): self
    {
        $this->amount += $amount;

        return $this;
    }


    public function getAmount(): int
    {
        return $this->amount;
    }


    public function computeLevel(int $levels, int $min, int $max): int
    {
        if ($this->amount === 0) {
            return 0;
        }

        $frac = ($this->amount - $min ) / $max;

        return max(round($frac * $levels), 1);
    }
}
