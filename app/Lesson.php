<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Lesson
 * @package App
 * @property int id
 * @property string name
 * @property string description
 * @property string category
 * @property Collection course
 * @property \stdClass pivot
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Lesson extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'category'];


    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)
            ->withPivot(['teacher_id', 'duration', 'position']);
    }
}
