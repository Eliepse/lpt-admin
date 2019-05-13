<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Grade;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Grade::class, function (Faker $faker) {

    $date_start_at = \Carbon\Carbon::instance($faker->dateTime());
    $timetable_start_at = $date_start_at->copy()->setTime(10, 0);

    return [
        'location'           => $faker->city,
        'country'            => Arr::random(['france']),
//        'teacher_id' => null,
        'level'              => $faker->numberBetween(1, 4),
        'date_start_at'      => $date_start_at->copy(),
        'date_end_at'        => $date_start_at->addMonths(6),
        'days'               => Arr::random([1, 2, 3, 4, 5, 6, 7], $faker->numberBetween(1, 3)),
        'timetable_start_at' => $timetable_start_at,
        'timetable_end_at'   => $timetable_start_at->copy()->addHours(2),
    ];

});
