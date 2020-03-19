<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_categories = [
            'Dressing',
            'Bangles',
            'Cosmetics',
        ];

        foreach ($product_categories as $product_category)
            \App\Models\ProductCategory::create([
                'name' => $product_category,
                'slug' => Str::slug($product_category),
                'featured_image' => '/assets/media/products/product'.rand(1, 28).'.jpg',
            ]);

        $product_tags = [
            'Cheap',
            '2019',
            '2020',
            'Winter',
        ];

        foreach ($product_tags as $product_tag)
            \App\Models\ProductTag::create([
                'name' => $product_tag,
            ]);

        $service_categories = [
            'Saloon Services',
            'Health & Fitness',
        ];

        foreach ($service_categories as $service_category)
            \App\Models\ServiceCategory::create([
                'name' => $service_category,
                'slug' => Str::slug($product_category),
                'featured_image' => '/assets/media/products/product'.rand(1, 28).'.jpg',
            ]);
    }
}
