<?php

namespace App;

use App\Pivots\ClassroomLesson;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Classroom
 * @package App
 * @property string name
 * @property Collection $lessons
 * @property Collection $schedules
 */
class Classroom extends Model
{
    use SoftDeletes;

    protected $guarded = [];


    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class)
            ->using(ClassroomLesson::class)
            ->withPivot(['teacher_id', 'duration']);
    }


    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }


    /**
     * @param bool $toString
     * @return int|string
     */
    public function getDuration(bool $toString = false)
    {
        $duration = $this->lessons->reduce(function ($carry, $lesson) {
            return $carry + $lesson->pivot->duration;
        }, 0);

        return !$toString ? $duration : floor($duration / 60) . ' h ' . ($duration % 60) . ' min';
    }
}
