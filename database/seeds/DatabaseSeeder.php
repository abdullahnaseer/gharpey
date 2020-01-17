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

        \Illuminate\Support\Facades\DB::insert(
            'insert into oauth_clients (name, redirect, personal_access_client, password_client, revoked, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?)'
            , ['MobileApp', 'http://localhost', 0, 1, 0, \Carbon\Carbon::now()->toDateTimeString(), \Carbon\Carbon::now()->toDateTimeString()]);
    }
}
