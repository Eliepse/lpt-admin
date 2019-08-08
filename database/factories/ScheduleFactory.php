<?php

/* @var $factory Factory */

use App\Classroom;
use App\Office;
use App\Schedule;
use App\Sets\DaysSet;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;

$factory->define(Schedule::class, function (Faker $faker) {

    $start_at = Carbon::rawParse($faker->dateTimeBetween("-30 days", "+30 days"));

    return [
        'classroom_id' => function () {
            return factory(Classroom::class)->create()->id;
        },
        'office_id' => function () {
            return factory(Office::class)->create()->id;
        },
        'day' => Arr::random(DaysSet::getKeys()),
        'hour' => $faker->date("H:i"),
        'price' => $faker->numberBetween(0, 750),
        'start_at' => $start_at,
        'end_at' => $start_at->clone()->addMonths($faker->numberBetween(1, 8)),
        'max_students' => $faker->numberBetween(5, 25),
    ];

});
