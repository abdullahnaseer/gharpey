<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\ServiceSeller::class, function (Faker $faker) {
    $arr = [500,1000,750,1500,2500];
    return [
        'short_description' => $faker->sentence,
        'long_description' => $faker->randomHtml(),
        'price' => $arr[array_rand($arr)],
//        'featured_image' => $faker->imageUrl(),
        'featured_image' => '/assets/media/products/product'.rand(1, 28).'.jpg',
    ];
});
