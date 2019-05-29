<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Classroom;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Classroom::class, function (Faker $faker) {

    // We generate an array of hours
    $hours = [];
    for ($h = 9 * 60; $h < 17 * 60; $h += 30) {
        $c = \Carbon\Carbon::create(0, 0, 0, 0, 0, 0)->addMinutes($h);
        $hours[] = $c->toTimeString();
    }

    // Then we generate and fill an array of days
    $timetables = Arr::random(\App\Sets\DaysSet::getKeys(), $faker->numberBetween(1, 3));
    $timetables = array_map(function ($item, $key) use ($hours, $faker) {
        return Arr::random($hours, $faker->numberBetween(1, 6));
    }, $timetables);

    $booking_open_at = \Carbon\Carbon::now()->subDays($faker->numberBetween(-30, 30));
    $date_first_day = \Carbon\Carbon::instance($faker->dateTimeThisYear());

    return [
        'name' => $faker->text(35),
        'timetables' => $timetables,
        'first_day' => $date_first_day->copy(),
        'last_day' => $date_first_day->addMonths($faker->numberBetween(4, 12)),
        'booking_open_at' => $booking_open_at,
        'booking_close_at' => $booking_open_at->copy()->addDays($faker->numberBetween(7, 30)),
    ];
});
