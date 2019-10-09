<?php

namespace App;

use App\Enums\DaysEnum;
use App\Pivots\ScheduleTeacher;
use App\Relations\HasSubscribers;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Schedule
 *
 * @package App
 * @property-read int id
 * @property int course_id
 * @property int campus_id
 * @property string|null $room
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
 * /
 * @property int duration
 * Relations:
 * @property Campus campus
 * @property Course course
 * @property \Illuminate\Support\Collection students
 * @property int subscriptions_count
 */
class Schedule extends Model
{
    use HasSubscribers,
        SoftDeletes;

    public const SCHEDULE_IS_INCOMMING = 0;
    public const SCHEDULE_IS_SIGNUP = 2;
    public const SCHEDULE_IS_STUDY = 3;
    public const SCHEDULE_IS_OVER = 1;

    protected $fillable = ['room', 'day', 'hour', 'price', 'max_students',
        'start_at', 'end_at', 'signup_start_at', 'signup_end_at'];

    protected $dates = ['start_at', 'end_at', 'signup_start_at', 'signup_end_at'];

    // TODO(eliepse): optimize it by using already loaded relation (removes a sql query)
    protected $withCount = ['subscriptions'];


    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }


    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(StaffUser::class, 'schedule_teacher', 'schedule_id', 'teacher_id')
            ->using(ScheduleTeacher::class);
    }


    /**
     * @return BelongsTo
     */
    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }


    public function getDurationAttribute(): int
    {
        return $this->course->getDuration();
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


    public function isSignupPeriod(): bool
    {
        if (empty($this->signup_start_at) || empty($this->signup_end_at))
            return false;

        return Carbon::now()->isBetween($this->signup_start_at, $this->signup_end_at->endOfDay(), true);
    }


    public function isStudyPeriod(): bool
    {
        return Carbon::now()->isBetween($this->start_at->startOfDay(), $this->end_at->endOfDay(), true);
    }


    /**
     * @return bool
     * @throws Exception
     */
    public function isClassNow(): bool
    {
        if (!$this->isStudyPeriod())
            return false;

        if (DaysEnum::getKey(Carbon::now()->dayOfWeek) !== $this->day)
            return false;

        $end = $this->hour->clone()->addMinutes($this->duration);

        return Carbon::now()->isBetween($this->hour, $end, true);
    }


    public function getStudents(): \Illuminate\Support\Collection
    {
        return $this->getSubscribers();
    }


    public function getStudentsAttribute(): \Illuminate\Support\Collection
    {
        return $this->getStudents();
    }


    public function getPrice(): int
    {
        return $this->price;
    }
}
