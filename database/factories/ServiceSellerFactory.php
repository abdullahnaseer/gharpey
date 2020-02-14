<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\ServiceSeller::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence,
        'price' => array_rand([500,1000,750,1500,2500]),
//        'featured_image' => $faker->imageUrl(),
        'featured_image' => '/assets/media/products/product'.rand(1, 28).'.jpg',
    ];
});
