<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\sensordata;
use Faker\Generator as Faker;

$factory->define(sensordata::class, function (Faker $faker) {
    return [
        'machine_id' => $faker->randomDigit,
        'RIV' => $faker->randomNumber($nbDigits = 3, $strict = false),
        'BIV' => $faker->randomNumber($nbDigits = 3, $strict = false),
        'YIV' => $faker->randomNumber($nbDigits = 3, $strict = false),
        
        
    ];
});
