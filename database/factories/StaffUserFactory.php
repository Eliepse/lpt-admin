<?php

/** @var Factory $factory */

use App\Sets\UserRolesSet;
use App\StaffUser;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(StaffUser::class, function (Faker $faker) {

    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'type' => 'staff',
        'roles' => new UserRolesSet(Arr::random(UserRolesSet::getKeys(), 1)),
        'wechat_id' => $faker->userName . $faker->randomNumber(4),
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
//        'email_verified_at' => now(),
    ];
});
