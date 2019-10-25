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
            'name' => "Admin",
            'email' => "abdullahnaseer999@gmail.com",
            'password' => \Hash::make('secret'),
        ]);
    }
}
