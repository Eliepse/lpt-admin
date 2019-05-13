<?php

namespace App;

use App\Pivots\StudentParent;
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
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Student extends Model
{
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
        return $this->belongsToMany(Grade::class, 'student_grade');
    }

}
