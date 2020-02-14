<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sellers = \App\Models\Seller::all();
        $categories = \App\Models\ProductCategory::all();

        factory(\App\Models\Product::class, 50)->create([
            'seller_id' => $sellers->random()->id,
            'category_id' => $categories->random()->id,
        ])->each(function ($product) use ($sellers, $categories) {
            $product->update([
                'slug' => \Illuminate\Support\Str::slug($product->name . ' ' . $product->id),
                'seller_id' => $sellers->random()->id,
                'category_id' => $categories->random()->id,
            ]);
        });
    }
}
