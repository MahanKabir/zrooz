<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Person;
use Faker\Generator as Faker;

$factory->define(Person::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName(),
        'code' => $faker->countryCode(),
        'phone' => $faker->phoneNumber(),
        'email' => $faker->email(),
        'value' => $faker->numberBetween(1000,99999),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
