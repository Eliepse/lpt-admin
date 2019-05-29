<?php

namespace App;


use App\Scopes\StaffUserScope;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StaffUser extends User
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StaffUserScope);
    }


    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }
}
