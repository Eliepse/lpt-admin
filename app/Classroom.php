<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Classroom
 * @package App
 * @property string name
 * @property Collection $lessons
 * @property Collection $schedules
 */
class Classroom extends Model
{
    use SoftDeletes;

    protected $guarded = [];


    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class);
    }


    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
