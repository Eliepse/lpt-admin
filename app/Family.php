<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Family
 * @package App
 * @property int id
 * @property Collection parents
 * @property Collection students
 * @property Collection children
 */
class Family extends Model
{
    public function parents(): HasMany
    {
        return $this->hasMany(User::class);
    }


    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }


    public function children(): HasMany
    {
        return $this->students();
    }
}
