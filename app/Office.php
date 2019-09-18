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
     * @return HasMany
     */
    public function activeSchedules(): HasMany
    {
        $today = Carbon::now()->toDateString();

        return $this->schedules()
            ->where([
                ['start_at', '<=', $today],
                ['end_at', '>=', $today],
            ])
            ->orWhere([
                ['signup_start_at', '<=', $today],
                ['signup_end_at', '>=', $today],
            ]);
    }
}
