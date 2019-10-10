<?php


namespace App\Pivots;


use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class ParentStudent
 * @package App\Pivots
 *
 * @property int $user_id
 * @property int $student_id
 * @property string $relation
 */
class ParentStudent extends Pivot
{
    protected $fillable = ['relation'];
}