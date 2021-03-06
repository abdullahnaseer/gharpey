<?php

use App\Models\Seller;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SellersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = \App\Models\CityArea::all();
        Seller::create([
            'name' => "Admin",
            'email' => "abdullahnaseer999@gmail.com",
            'password' => \Hash::make('secret123'),
            'phone' => "+923366633352",
            'cnic' => "36302-9925692-1",
            'shop_name' => 'Abdullah\'s Shop',
            'shop_slug' => 'abdullah-shop',
            'shop_image' => '/assets1/images/products/h4.png',
            'approved_at' => Carbon::now()->toDateTimeString(),
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'phone_verified_at' => Carbon::now()->toDateTimeString(),
            'business_address' => 'Business/ Address',
            'business_location_id' => $areas->random()->id,
            'warehouse_address' => 'Warehouse/ Address',
            'warehouse_location_id' => $areas->random()->id,
            'return_address' => 'Return/ Address',
            'return_location_id' => $areas->random()->id,
        ]);

        Seller::create([
            'name' => "Admin",
            'email' => "abdullah.billx@gmail.com",
            'password' => \Hash::make('secret123'),
            'phone' => "+923366633352",
            'cnic' => "36302-9925692-1",
            'shop_name' => 'Malik\'s Shop',
            'shop_slug' => 'malik-shop',
            'shop_image' => '/assets1/images/products/h3.png',
            'approved_at' => Carbon::now()->toDateTimeString(),
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'phone_verified_at' => Carbon::now()->toDateTimeString(),
            'business_address' => 'Business/ Address',
            'business_location_id' => $areas->random()->id,
            'warehouse_address' => 'Warehouse/ Address',
            'warehouse_location_id' => $areas->random()->id,
            'return_address' => 'Return/ Address',
            'return_location_id' => $areas->random()->id,
        ]);

        Seller::create([
            'name' => "Shahzaib Munawar",
            'email' => "m.shahzaib108@gmail.com",
            'password' => \Hash::make('secret123'),
            'phone' => "+923484022311",
            'cnic' => "36302-9925692-1",
            'shop_name' => 'Shahzaib\'s Shop',
            'shop_slug' => 'shahzaib-shop',
            'shop_image' => '/assets1/images/products/h2.png',
            'approved_at' => Carbon::now()->toDateTimeString(),
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'phone_verified_at' => Carbon::now()->toDateTimeString(),
            'business_address' => 'Business/ Address',
            'business_location_id' => $areas->random()->id,
            'warehouse_address' => 'Warehouse/ Address',
            'warehouse_location_id' => $areas->random()->id,
            'return_address' => 'Return/ Address',
            'return_location_id' => $areas->random()->id,
        ]);

    }
}
