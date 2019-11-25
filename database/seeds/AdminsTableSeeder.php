<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => "Muhammad Abdullah",
            'email' => "abdullahnaseer999@gmail.com",
            'password' => \Hash::make('secret123'),
        ]);

        Admin::create([
            'name' => "Malik Abdullah",
            'email' => "abdullah.billx@gmail.com",
            'password' => \Hash::make('secret123'),
        ]);
    }
}
