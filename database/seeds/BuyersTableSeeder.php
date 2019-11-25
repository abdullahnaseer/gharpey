<?php

use App\Models\Buyer;
use Illuminate\Database\Seeder;

class BuyersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Buyer::create([
            'name' => "Muhammad Abdullah",
            'email' => "abdullahnaseer999@gmail.com",
            'password' => \Hash::make('secret123'),
        ]);

        Buyer::create([
            'name' => "Malik Abdullah",
            'email' => "abdullah.billx@gmail.com",
            'password' => \Hash::make('secret123'),
        ]);
    }
}
