<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Grade;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Grade::class, function (Faker $faker) {

    return [
        'title' => $faker->text(50),
        'location' => Arr::random(['aubervilliers', 'belleville']),
        'country' => Arr::random(['france']),
        'level' => $faker->numberBetween(1, 4),
        'max_students' => $faker->numberBetween(5, 15),
        'price' => $faker->numberBetween(5, 10) * 50,
    ];

});
