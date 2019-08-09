<?php

namespace App;


use App\Pivots\ScheduleTeacher;
use App\Scopes\StaffUserScope;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StaffUser extends User
{

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StaffUserScope);
    }


    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class, 'schedule_teacher', 'teacher_id', 'schedule_id')
            ->using(ScheduleTeacher::class);
    }
}
