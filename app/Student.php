<?php

namespace App;

use App\Pivots\ParentStudent;
use App\Pivots\StudentSchedule;
use App\Traits\HasHumanNames;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Student
 * @package App
 * @property int id
 * @property string firstname
 * @property string lastname
 * @property Carbon birthday
 * @property string notes
 * @property Collection parents
 * @property Collection classrooms
 * @property StudentSchedule subscription
 * @property Family family
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Student extends Model
{
    use SoftDeletes;
    use HasHumanNames;

    protected $fillable = ['firstname', 'lastname', 'birthday', 'notes'];

    protected $dates = [
        'birthday',
    ];


    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'parent_student')
            ->using(ParentStudent::class)
            ->withPivot([
                'relation',
            ]);
    }


    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }


    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class)
            ->using(StudentSchedule::class)
            ->as('subscription')
            ->withPivot([
                'price',
                'paid',
            ]);
    }


    public function getAge(): int
    {
        return $this->birthday->diffInYears();
    }
}
