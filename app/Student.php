<?php

namespace App;

use App\Pivots\StudentGrade;
use App\Pivots\StudentParent;
use App\Traits\HasHumanNames;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Student
 * @package App
 * @property int id
 * @property string firstname
 * @property string lastname
 * @property Carbon birthday
 * @property string notes
 * @property Collection parents
 * @property Collection grades
 * @property StudentGrade subscription
 * @property Family family
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Student extends Model
{
    use HasHumanNames;

    protected $fillable = ['firstname', 'lastname', 'birthday', 'notes'];

    protected $dates = [
        'birthday',
    ];


    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'student_parent')
            ->using(StudentParent::class)
            ->withPivot([
                'relation',
            ]);
    }


    public function grades(): BelongsToMany
    {
        return $this->belongsToMany(Grade::class)
            ->using(StudentGrade::class)
            ->as('subscription')
            ->withPivot([
                'price',
                'paid',
            ]);
    }


    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }


    public function getActiveGrades($only_started = false): Collection
    {
        return $this->grades()
            ->whereDate('last_day', '>=', Carbon::now())
            ->get();
    }


    public function getAge(): int
    {
        return $this->birthday->diffInYears();
    }
}
