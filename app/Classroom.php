<?php

namespace App;

use App\Pivots\ClassroomStudent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * Class Classroom
 * @package App
 * @property string|null name
 * @property Collection timetables
 * @property string location
 * @property int max_students
 * @property Carbon $first_day
 * @property Carbon $last_day
 * @property Carbon $booking_open_at
 * @property Carbon $booking_close_at
 * @property EloquentCollection $students
 * @property EloquentCollection $grades
 * @property StaffUser teacher
 * @method static Builder bookable
 */
class Classroom extends Model
{
    protected $fillable = ['name', 'location', 'max_students', 'timetables',
        'first_day', 'last_day', 'booking_open_at', 'booking_close_at'];

    protected $casts = ['timetables' => 'array'];

    protected $dates = ['first_day', 'last_day', 'booking_open_at', 'booking_close_at'];


    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)
            ->using(ClassroomStudent::class)
            ->as('subscription')
            ->withPivot([
                'price',
                'paid',
            ]);
    }


    public function grades(): BelongsToMany
    {
        return $this->belongsToMany(Grade::class);
    }


    public function teacher(): BelongsTo
    {
        return $this->belongsTo(StaffUser::class, 'teacher_id');
    }


    public function isBookingOpen(): bool
    {
        return $this->booking_open_at->isPast() && $this->booking_close_at->isFuture();
    }


    public function scopeBookable(Builder $query): Builder
    {
        $now = Carbon::now();

        return $query->whereDate('booking_open_at', '<=', $now)
            ->whereDate('booking_close_at', '>=', $now);
    }


    public static function bookableAvailable(): bool
    {
        return static::bookable()->exists();
    }
}
