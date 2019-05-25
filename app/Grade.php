<?php

namespace App;

use Carbon\Carbon;
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
 * @property Carbon start_at
 * @property Carbon end_at
 * @property array timetable_days
 * @property Carbon timetable_hour
 * @property Collection|null students
 * @property User|null teacher
 * @property Collection|null courses
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Grade extends Model
{
    protected $fillable = [
        'title', 'location', 'country', 'level', 'max_students',
        'price', 'start_at', 'end_at', 'timetable_days', 'timetable_hour',
    ];

    protected $casts = [
        'start_at' => 'datetime:Y-m-d',
        'end_at' => 'datetime:Y-m-d',
        'timetable_day' => 'array',
//        'timetable_hour' => 'datetime:H:i',
    ];


    public function getTimetableDaysAttribute(string $value): array
    {
        return explode(',', $value);
    }


    public function setTimetableDaysAttribute(array $options)
    {
        $this->attributes['timetable_days'] = join(',', $options);
    }


    public function getTimetableHourAttribute($hour): Carbon
    {
        return Carbon::createFromTimeString($hour);
    }


    public function setTimetableHourAttribute($value): void
    {
        $this->attributes['timetable_hour'] = Carbon::createFromTimeString($value)->toDateTimeString();
    }


    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }


    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_grade');
    }


    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }


    /**
     * Return the global duration in minutes of the courses
     * @return int
     */
    public function getDuration(): int
    {
        return $this->courses->sum('duration');
    }

}