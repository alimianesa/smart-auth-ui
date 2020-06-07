<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SpeechText;
use Faker\Generator as Faker;

$factory->define(SpeechText::class, function (Faker $faker) {
    return [
        'speech_text' => $faker->sentence(20)
    ];
});
