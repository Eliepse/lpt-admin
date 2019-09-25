<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Campus;
use Faker\Generator as Faker;

$factory->define(Campus::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
    ];
});
