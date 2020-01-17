<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;

class ModeratorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Moderator::create([
            'name' => "Muhammad Abdullah",
            'email' => "abdullahnaseer999@gmail.com",
            'password' => \Hash::make('secret123'),
        ]);

        \App\Models\Moderator::create([
            'name' => "Malik Abdullah",
            'email' => "abdullah.billx@gmail.com",
            'password' => \Hash::make('secret123'),
        ]);

        \App\Models\Moderator::create([
            'name' => "Shahzaib Munawar",
            'email' => "m.shahzaib108@gmail.com",
            'password' => \Hash::make('secret123'),
        ]);
    }
}
