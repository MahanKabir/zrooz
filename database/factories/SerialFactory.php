<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Serial;
use Faker\Generator as Faker;

$factory->define(Serial::class, function (Faker $faker) {
    return [
        'serial' => $faker->numberBetween(1000000000000000, 9999999999999999),
        'value01' => $faker->numberBetween(1000, 99999),
        'value02' => $faker->numberBetween(1000, 99999),
        'check' => $faker->numberBetween(0, 1),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
