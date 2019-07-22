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
 * @property-read Carbon updated_at
 * @property-read Carbon created_at
 * @property-read Collection schedules
 * @property-read Collection activeSchedules
 */
class Office extends Model
{
    protected $guarded = [];

    protected $with = ['schedules'];


    /**
     * @return HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function activeSchedules(): HasMany
    {
        return $this->schedules()
            ->whereDate('start_at', '<=', Carbon::now())
            ->whereDate('end_at', '>=', Carbon::now());
    }
}
