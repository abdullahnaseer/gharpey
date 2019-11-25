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
        Seller::create([
            'name' => "Admin",
            'email' => "abdullahnaseer999@gmail.com",
            'password' => \Hash::make('secret123'),
            'phone' => "+923366633352",
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'phone_verified_at' => Carbon::now()->toDateTimeString()
        ]);

        Seller::create([
            'name' => "Admin",
            'email' => "abdullah.billx@gmail.com",
            'password' => \Hash::make('secret123'),
            'phone' => "+923366633352",
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'phone_verified_at' => Carbon::now()->toDateTimeString()
        ]);
    }
}
