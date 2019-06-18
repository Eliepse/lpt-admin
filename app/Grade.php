<?php

namespace App;

use App\Pivots\GradeLesson;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Grade
 * @package App
 * @property int id
 * @property string title
 * @property string description
 * @property string country
 * @property int|null teacher_id
 * @property int|null level
 * @property int price
 * @property User|null teacher
 * @property Collection|null lessons
 * @property Collection|null classrooms
 * @property Carbon created_at
 * @property Carbon updated_at
 * @method static Builder registrable
 */
class Grade extends Model
{
    protected $fillable = [
        'title', 'description', 'location', 'country', 'level', 'max_students', 'price',
    ];


    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class)
            ->using(GradeLesson::class)
            ->withPivot(['teacher_id', 'duration']);
    }


    public function teacher(): BelongsTo
    {
        return $this->belongsTo(StaffUser::class, 'teacher_id');
    }


    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class);
    }


    public function bookableClassrooms(): BelongsToMany
    {
        return $this->classrooms()
            ->whereDate('booking_open_at', '<=', Carbon::now())
            ->whereDate('booking_close_at', '>=', Carbon::now());
    }


    /**
     * Return the global duration in minutes of the lessons
     * @return int
     */
    public function getDuration(): int
    {
        return $this->lessons->sum('duration');
    }


    public function getDurationString(): string
    {
        $duration = $this->getDuration();
        $hours = floor($duration / 60);
        $minutes = $duration % 60;

        return "$hours h $minutes min";
    }

}