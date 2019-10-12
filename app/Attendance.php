<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Attendance
 * @package App
 *
 * @property int $id
 * @property int $student_id
 * @property int $attendable_id
 * @property string $attendable_type
 * @property Carbon $referred_date
 * @property string $state
 * @property string $reason
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Model $attendable
 * @property Schedule $schedule
 *
 * @method static Builder ofSchedule(Schedule $schedule)
 * @method static Builder ofStudent(Student $student)
 * @method static Builder ofState(string $state)
 */
class Attendance extends Model
{
    public const STATE_PRESENT = 'present';
    public const STATE_ABSENT = 'absent';
    public const STATE_LATE = 'late';

    protected $guarded = [];

    protected $casts = [
        'referred_date' => 'datetime:Y-m-d',
    ];

    /**
     * Attendable is the person (Student, StaffUser,...) that supposed to attend a schedule
     *
     * @return MorphTo
     */
    public function attendable(): MorphTo
    {
        return $this->morphTo('attendable');
    }

    /**
     * The schedule that has to be attended
     *
     * @return BelongsTo
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Scope a specific schedule
     *
     * @param Builder $builder
     * @param Schedule $schedule
     *
     * @return Builder
     */
    public function scopeOfSchedule(Builder $builder, Schedule $schedule): Builder
    {
        return $builder->where('schedule_id', $schedule->id);
    }

    /**
     * Scope a specific student
     *
     * @param Builder $builder
     * @param Student $student
     *
     * @return Builder
     */
    public function scopeOfStudent(Builder $builder, Student $student): Builder
    {
        return $builder
            ->where('attendable_id', $student->id)
            ->where('attendable_type', Student::class);
    }

    /**
     * Scope a specific state
     *
     * @param Builder $builder
     * @param string $state
     *
     * @return Builder
     */
    public function scopeOfState(Builder $builder, string $state): Builder
    {
        return $builder->where('state', $state);
    }
}
