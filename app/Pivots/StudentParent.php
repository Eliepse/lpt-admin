<?php


namespace App\Pivots;


use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Arr;

/**
 * Class StudentParent
 * @package App\Pivots
 * @property int user_id
 * @property int student_id
 * @property string relation
 */
class StudentParent extends Pivot
{
    protected $fillable = ['relation'];
}