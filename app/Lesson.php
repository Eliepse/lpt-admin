<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Class Lesson
 * @package App
 * @property int id
 * @property string name
 * @property string description
 * @property string category
 * @property Collection grades
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Lesson extends Model
{
    protected $fillable = ['name', 'description', 'duration', 'category'];


    public function grades(): BelongsToMany
    {
        return $this->belongsToMany(Grade::class);
    }
}
