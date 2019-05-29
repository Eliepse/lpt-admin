<?php


namespace App\Pivots;


use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Arr;

/**
 * Class StudentParent
 * @package App\Pivots
 * @property int grade_id
 * @property int lesson_id
 * @property int|null teacher_id
 * @property int duration
 */
class GradeLesson extends Pivot
{
    protected $fillable = ['teacher_id', 'duration'];
}