<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Video;
use Faker\Generator as Faker;

$factory->define(Video::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'size' => $this->faker->randomNumber(4),
        'viewers' => $this->faker->randomNumber(4),
    ];
});
