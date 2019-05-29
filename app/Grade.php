<?php

namespace App;

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
 * @property string location
 * @property string country
 * @property int|null teacher_id
 * @property int|null level
 * @property int max_students
 * @property int price
 * @property User|null teacher
 * @property Collection|null lessons
 * @property Carbon created_at
 * @property Carbon updated_at
 * @method static Builder registrable
 */
class Grade extends Model
{
    protected $fillable = [
        'title', 'location', 'country', 'level', 'max_students', 'price',
    ];


    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class);
    }


    public function teacher(): BelongsTo
    {
        return $this->belongsTo(StaffUser::class, 'teacher_id');
    }


    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class);
    }


    /**
     * Return the global duration in minutes of the lessons
     * @return int
     */
    public function getDuration(): int
    {
        return $this->lessons->sum('duration');
    }

}