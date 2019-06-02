<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Grade;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Grade::class, function (Faker $faker) {

    return [
        'title' => $faker->text(50),
        'description' => $faker->text(200),
        'level' => $faker->numberBetween(0, 6),
        'price' => $faker->numberBetween(5, 10) * 50,
    ];

});
