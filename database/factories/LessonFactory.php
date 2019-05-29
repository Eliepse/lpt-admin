<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Lesson;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Lesson::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
        'description' => $faker->text(50),
        'category' => Arr::random(\App\Enums\LessonCategoryEnum::getKeys()),
    ];
});
