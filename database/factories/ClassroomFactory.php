<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Classroom;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Classroom::class, function (Faker $faker) {
    return [
        'name' => $faker->text(35),
    ];
});
