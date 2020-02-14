<?php

use Illuminate\Database\Seeder;

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
            for ($i = 0, $iMax = rand(4, 8); $i <= $iMax; $i++)
            {
                $question = ($service->questions()->save(factory(App\Models\ServiceQuestion::class)->make([])));
                if($question->type == \App\Models\ServiceQuestion::TYPE_SELECT || $question->type == \App\Models\ServiceQuestion::TYPE_SELECT_MULTIPLE)
                    factory(App\Models\ServiceQuestionChoices::class, rand(3,7))->create(['question_id' => $question->id]);
            }
        });
    }
}
