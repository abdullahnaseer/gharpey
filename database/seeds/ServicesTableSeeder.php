<?php

use Illuminate\Database\Seeder;
use App\Models\Classes\ServiceQuestionType;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = \App\Models\ServiceCategory::all();

        factory(\App\Models\Service::class, 12)->create([
            'category_id' => $categories->random()->id,
        ])->each(function ($service) use ($categories) {
            $service->update([
                'slug' => \Illuminate\Support\Str::slug($service->name . ' ' . $service->id),
                'category_id' => $categories->random()->id,
            ]);
        });
    }
}
