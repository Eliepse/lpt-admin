<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Office
 *
 * @package App
 * @property-read int id
 * @property string name
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
}
