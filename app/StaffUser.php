<?php

namespace App;


use App\Scopes\StaffUserScope;

class StaffUser extends User
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StaffUserScope);
    }
}
