<?php

/** @var Factory $factory */

use App\ClientUser;
use App\Family;
use App\Sets\UserRolesSet;
use Illuminate\Database\Eloquent\Factory;
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

$factory->define(ClientUser::class, function (Faker $faker) {

    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'type' => 'client',
        'wechat_id' => $faker->userName . $faker->randomNumber(4),
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'family_id' => function () {
            return factory(Family::class)->create()->id;
        }
//        'email_verified_at' => now(),
    ];
});
