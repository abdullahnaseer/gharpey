<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Helpers\ServiceQuestionType\ServiceQuestionType;
use Faker\Generator as Faker;

$factory->define(\App\Models\ServiceQuestion::class, function (Faker $faker) {
    $types = \App\Helpers\ServiceQuestionAuthRule::getAllTypes();
    $types[] = null;

    return [
        'name' => $faker->word,
        'question' => $faker->sentence . '?',
        'placeholder' => $faker->sentence,
//        'auth_rule' => $faker->randomElement($types),
        'type' => $faker->randomElement(ServiceQuestionType::getAllTypes()),
    ];
});
