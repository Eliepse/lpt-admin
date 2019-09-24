<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Office
 *
 * @package App
 * @property-read int id
 * @property string name
 * @property string|null postal_address
 * @property-read Carbon updated_at
 * @property-read Carbon created_at
 * @property-read Collection schedules
 * @property-read Collection activeSchedules
 */
class Office extends Model
{
    protected $guarded = [];

//    protected $with = ['schedules'];


    /**
     * @return HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }


    /**
     * Prepare a query to retreive schedules that are currently active,
     * or with an active registration process
     *
     * @return Collection
     */
    public function getActiveSchedules(): Collection
    {
        $today = Carbon::now();

        return $this->schedules
            ->filter(function (Schedule $schedule) use ($today) {
                return $today->isBetween($schedule->start_at, $schedule->end_at)
                    || $today->isBetween($schedule->signup_start_at, $schedule->signup_end_at);
            });
    }
}
