<?php

use Illuminate\Database\Seeder;

class CityAreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = \App\Models\Country::create(['name' => 'Pakistan']);

        $states = ['PN' => 'Punjab', 'SN' =>  'Sindh', 'BL' => 'Balochistan', 'KP' => 'Khyber Pakhtunkhwa', 'IS' => 'Islamabad Capital Territory'];
        foreach ($states as $iso => $state)
            \App\Models\State::create(['name' => $state, 'iso' => $iso, 'country_id' => $country->id]);

        $state = \App\Models\State::where('name', 'Islamabad Capital Territory')->first();
        $cities = ['Islamabad'];
        foreach ($cities as $city)
            \App\Models\City::create(['state_id' => $state->id, 'name' => $city]);

        $state = \App\Models\State::where('name', 'Punjab')->first();
        $cities = ['Rawalpindi', 'Lahore', 'Multan'];
        foreach ($cities as $city)
            \App\Models\City::create(['state_id' => $state->id, 'name' => $city]);

        $state = \App\Models\State::where('name', 'Sindh')->first();
        $cities = ['Karachi', 'Hyderabad'];
        foreach ($cities as $city)
            \App\Models\City::create(['state_id' => $state->id, 'name' => $city]);


        $state = \App\Models\State::where('name', 'Balochistan')->first();
        $cities = ['Queta', 'Gawadar'];
        foreach ($cities as $city)
            \App\Models\City::create(['state_id' => $state->id, 'name' => $city]);

        $state = \App\Models\State::where('name', 'Khyber Pakhtunkhwa')->first();
        $cities = ['Peshawar', 'Naran'];
        foreach ($cities as $city)
            \App\Models\City::create(['state_id' => $state->id, 'name' => $city]);




        $city = \App\Models\City::where('name', 'Islamabad')->first();
        $areas = ['DHA Phase 1', 'Bahria Enclave', 'Green Avenue'];
        foreach ($areas as $area)
            \App\Models\CityArea::create(['city_id' => $city->id, 'name' => $area, 'zip' => '10000']);

        $city = \App\Models\City::where('name', 'Multan')->first();
        $areas = ['Shah Rukn-e-Alam Colony', 'Gulgasht Colony'];
        foreach ($areas as $area)
            \App\Models\CityArea::create(['city_id' => $city->id, 'name' => $area, 'zip' => '60000']);
    }
}
