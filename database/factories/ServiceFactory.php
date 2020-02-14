<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Service::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
//        'featured_image' => $faker->imageUrl(),
        'featured_image' => '/assets/media/products/product'.rand(1, 28).'.jpg',
    ];
});
