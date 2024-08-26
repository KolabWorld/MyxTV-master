<?php

use Faker\Generator as Faker;
use Models\User;

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

$factory->define(User::class, function (Faker $faker) {
    $email = $faker->unique()->safeEmail;
    return [
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'user_name' => $email,
        'email' => $email,
        'mobile' => $faker->phoneNumber(),
        'password' => '123456', // secret
        'remember_token' => str_random(10),
    ];
});
