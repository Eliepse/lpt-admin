<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Family;
use App\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {

    $faker_cn = \Faker\Factory::create('zh_CN');
    $withChineseNames = $faker->boolean;

    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'firstname_zh' => $withChineseNames ? $faker_cn->firstName : null,
        'lastname_zh' => $withChineseNames ? $faker_cn->lastName : null,
        'birthday' => $faker->dateTimeBetween('-12 years', 'now'),
        'family_id' => factory(Family::class)->create()->id,
    ];

});
