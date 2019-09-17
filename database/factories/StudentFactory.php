<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Family;
use App\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {

    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->firstName,
        'birthday' => $faker->dateTimeBetween('-12 years', 'now'),
        'family_id' => factory(Family::class)->create()->id,
    ];

});
