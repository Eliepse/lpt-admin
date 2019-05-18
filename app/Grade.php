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
 * @property string location
 * @property string country
 * @property int teacher_id
 * @property int level
 * @property Carbon date_start_at
 * @property Carbon date_end_at
 * @property Carbon timetable_start_at
 * @property Carbon timetable_end_at
 * @property Collection students
 * @property User teacher
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Grade extends Model
{
    protected $casts = [
        'timetable_start_at' => 'datetime:H:i:s',
        'timetable_end_at'   => 'datetime:H:i:s',
        'date_start_at'      => 'datetime:Y-m-d',
        'date_end_at'        => 'datetime:Y-m-d',
    ];


    public function getDaysAttribute(string $value): array
    {
        return explode(',', $value);
    }


    public function setDaysAttribute(array $options)
    {
        $this->attributes['days'] = join(',', $options);
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

}