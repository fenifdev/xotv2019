<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Video;
use Faker\Generator as Faker;

$factory->define(Video::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'size' => $this->faker->randomFloat(2, null, 8),
        'viewers' => $this->faker->randomNumber(4),
    ];
});
