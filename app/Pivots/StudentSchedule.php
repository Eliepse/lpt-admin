<?php


namespace App\Pivots;


use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Arr;

/**
 * Class StudentParent
 *
 * @package App\Pivots
 * @property int timetable_id
 * @property int student_id
 * @property int price
 * @property int paid
 */
class StudentSchedule extends Pivot
{
    protected $fillable = ['price', 'paid'];


    public function unpaidAmount(): int
    {
        return $this->price - $this->paid;
    }


    public function isPaid(): bool
    {
        return $this->paid >= $this->price;
    }


    public function isOverPaid(): bool
    {
        return $this->paid > $this->price;
    }
}
