<?php

namespace App;

use App\Pivots\CourseLesson;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Course
 *
 * @package App
 * @property-read int id
 * @property string name
 * @property string description
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 * @property Collection $lessons
 * @property Collection $schedules
 */
class Course extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['lessons'];


    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class)
            ->using(CourseLesson::class)
            ->withPivot(['duration']);
    }


    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }


    public function getActiveSchedules(): Collection
    {
        $today = Carbon::now();

        return $this->schedules
            ->filter(function (Schedule $schedule) use ($today) {
                return $today->isBetween($schedule->start_at, $schedule->end_at)
                    || $today->isBetween($schedule->signup_start_at, $schedule->signup_end_at);
            });
    }


    /**
     * @param bool $toString
     *
     * @return int|string
     */
    public function getDuration(bool $toString = false)
    {
        $duration = $this->lessons->reduce(function ($carry, $lesson) {
            return $carry + $lesson->pivot->duration;
        }, 0);

        $seconds = $duration % 60;

        return !$toString ? $duration : floor($duration / 60) . ' h ' .
            ($seconds < 10 ? '0' . $seconds : $seconds) . ' min';
    }
}
