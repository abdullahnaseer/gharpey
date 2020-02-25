<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Product::class, function (Faker $faker) {
    $arr = [500,1000,750,1500,2500];
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
//        'featured_image' => $faker->imageUrl(),
        'featured_image' => '/assets/media/products/product'.rand(1, 28).'.jpg',
        'price' => $arr[array_rand($arr)],
        'inventory' => rand(0, 15),
    ];
});
