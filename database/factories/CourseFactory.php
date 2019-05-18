<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Course;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'name'        => $faker->jobTitle,
        'description' => $faker->text(50),
        'category'    => Arr::random(['language', 'art', 'activity']),
        'duration'    => $faker->numberBetween(1, 6) * 15,
    ];
});
