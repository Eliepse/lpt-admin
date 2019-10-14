<?php

/** @var Factory $factory */

use App\Attendance;
use App\Model;
use App\Schedule;
use App\Student;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Attendance::class, function (Faker $faker) {
    return [
        'schedule_id' => function () {
            return factory(Schedule::class)->create()->id;
        },
        'attendable_id' => function () {
            return factory(Student::class)->create()->id;
        },
        'attendable_type' => Student::class,
        'state' => $faker->randomElement([
            Attendance::STATE_PRESENT,
            Attendance::STATE_ABSENT,
            Attendance::STATE_LATE,
        ]),
        'referred_day' => $faker->date(),
        'comment' => $faker->realText()
    ];
});
