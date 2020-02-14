<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\ServiceQuestion::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'question' => $faker->sentence . '?',
        'type' => $faker->randomElement(\App\Models\ServiceQuestion::TYPES),
        'is_required' => $faker->boolean,
        'auth_rule' => $faker->randomElement(\App\Models\ServiceQuestion::AUTH_RULES)
    ];
});
