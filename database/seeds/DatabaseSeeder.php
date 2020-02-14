<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CityAreasSeeder::class);

        $this->call(AdminsTableSeeder::class);
        $this->call(ModeratorsTableSeeder::class);
        $this->call(SellersTableSeeder::class);
        $this->call(BuyersTableSeeder::class);

        $this->call(CategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(ServiceSellerTableSeeder::class);
    }
}
