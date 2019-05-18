<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Class Course
 * @package App
 * @property int id
 * @property string name
 * @property string description
 * @property string category
 * @property int duration
 * @property bool active
 * @property int teacher_id
 * @property User teacher
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Course extends Model
{
    protected $fillable = ['name', 'description', 'duration', 'category'];


    public function grades(): BelongsToMany
    {
        return $this->belongsToMany(Grade::class);
    }


    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
