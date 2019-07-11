<?php


namespace App\Pivots;


use App\StaffUser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class ParentStudent
 * @package App\Pivots
 * @property int duration
 * @property string relation
 */
class ClassroomLesson extends Pivot
{
    protected $fillable = ['duration'];


    /**
     * @param bool $toString
     * @return int|string
     */
    public function getDuration(bool $toString = false)
    {
        $seconds = $this->duration % 60;

        return !$toString ? $this->duration : floor($this->duration / 60) . ' h ' .
            ($seconds < 10 ? '0' . $seconds : $seconds) . ' min';
    }
}