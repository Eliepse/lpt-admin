<?php

namespace App;


use App\Scopes\ClientUserScope;

class ClientUser extends User
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ClientUserScope());
    }
}
