<?php

namespace App;

use App\Pivots\ScheduleTeacher;
use App\Pivots\StudentSchedule;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Timetable
 *
 * @package App
 * @property-read int id
 * @property int classroom_id
 * @property int office_id
 * @property string day
 * @property Carbon hour
 * @property int price
 * @property int max_students
 * @property Carbon start_at
 * @property Carbon end_at
 * @property Carbon signup_start_at
 * @property Carbon signup_end_at
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Classroom classroom
 * @property Collection students
 */
class Schedule extends Model
{
    protected $guarded = [];

    protected $dates = ['first_day', 'last_day', 'booking_open_at', 'booking_close_at'];

//    protected $with = ['office'];

    protected $withCount = ['students'];


    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }


    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)
            ->using(StudentSchedule::class)
            ->withPivot([
                'price',
                'paid',
            ]);
    }


    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(StaffUser::class, 'schedule_teacher', 'schedule_id', 'teacher_id')
            ->using(ScheduleTeacher::class);
    }


    /**
     * @return BelongsTo
     */
    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }


    public function getDurationAttribute(): int
    {
        return $this->classroom->getDuration();
    }


    /**
     * @param $value
     *
     * @return bool|DateTime
     */
    public function getHourAttribute($value)
    {
        return Carbon::createFromFormat("H:i:s", $value);
    }
}
