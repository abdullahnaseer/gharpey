<?php

use Illuminate\Database\Seeder;

class ServiceSellerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sellers = \App\Models\Seller::all();
        $services = \App\Models\Service::all();
        $cities = \App\Models\City::all();

        foreach ($services as $service)
        {
            factory(\App\Models\ServiceSeller::class, rand(1, $services->count()))
                ->make()
                ->each(function ($serviceSeller) use ($service, $sellers, $cities)
                {
                    $serviceSeller->seller_id = $sellers->random()->id;
                    $serviceSeller->service_id = $service->id;
                    if(is_null(\App\Models\ServiceSeller::where('service_id', $service->id)
                        ->where('seller_id', $serviceSeller->seller_id)
                        ->first()))
                    {
                        $serviceSeller->save();
                        $serviceSeller->cities()->sync($cities->random(7)->pluck('id'));

                        for ($i = 0, $iMax = rand(4, 8); $i <= $iMax; $i++)
                        {
                            $question = ($serviceSeller->questions()->save(factory(App\Models\ServiceQuestion::class)->make([])));
                            if($question->type->isSelect())
                                factory(App\Models\ServiceQuestionChoices::class, rand(3,7))->create(['question_id' => $question->id]);
                        }
                    }
                });

        }
    }
}
