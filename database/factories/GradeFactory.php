<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Grade;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Grade::class, function (Faker $faker) {

    $date_first_day = \Carbon\Carbon::instance($faker->dateTime());
    $timetable_start_at = \Carbon\Carbon::now()->setTime($faker->numberBetween(9, 18), 0);

    return [
        'location' => $faker->city,
        'country' => Arr::random(['france']),
//        'teacher_id' => null,
        'level' => $faker->numberBetween(1, 4),
        'first_day' => $date_first_day->copy(),
        'last_day' => $date_first_day->addMonths($faker->numberBetween(4, 12)),
        'timetable_days' => Arr::random([1, 2, 3, 4, 5, 6, 7], $faker->numberBetween(1, 3)),
        'timetable_hour' => $timetable_start_at->format('H:i'),
    ];

});
