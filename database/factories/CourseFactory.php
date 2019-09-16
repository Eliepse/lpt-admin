<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Course;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'name' => $faker->text(35),
    ];
});
