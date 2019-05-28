<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Grade;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Grade::class, function (Faker $faker) {

    $date_first_day = \Carbon\Carbon::instance($faker->dateTime());
    $timetable_start_at = \Carbon\Carbon::now()->setTime($faker->numberBetween(9, 18), 0);
    $booking_open_at = \Carbon\Carbon::now()->subDays($faker->numberBetween(-30, 30));

    return [
        'title' => $faker->text(50),
        'location' => Arr::random(['aubervilliers', 'belleville']),
        'country' => Arr::random(['france']),
//        'teacher_id' => null,
        'level' => $faker->numberBetween(1, 4),
        'max_students' => $faker->numberBetween(5, 15),
        'price' => $faker->numberBetween(5, 10) * 50,
        'first_day' => $date_first_day->copy(),
        'last_day' => $date_first_day->addMonths($faker->numberBetween(4, 12)),
        'timetable_days' => Arr::random(['monday', 'tuesday', 'wednesday', 'thursday', 'friday',
            'saturday', 'sunday'], $faker->numberBetween(1, 3)),
        'timetable_hour' => $timetable_start_at->format('H:i'),
        'booking_open_at' => $booking_open_at,
        'booking_close_at' => $booking_open_at->copy()->addDays($faker->numberBetween(7, 30)),
    ];

});
