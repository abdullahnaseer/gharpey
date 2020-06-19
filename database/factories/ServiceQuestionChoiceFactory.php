<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\ServiceQuestionChoices::class, function (Faker $faker) {
    return [
        'choice' => $faker->word,
        'price_change' => $faker->numberBetween(-100, 100)
    ];
});
