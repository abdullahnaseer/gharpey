<?php

use Illuminate\Database\Seeder;

class ServiceQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $questions = [
            [
                'name' => 'guest.name',
                'title' => 'Whats your name?',
                'question' => 'Whats your name?',
                'type' => \App\Models\ServiceQuestion::TYPE_TEXT,
                'auth_rule' => \App\Models\ServiceQuestion::AUTH_GUEST,
                'is_required' => true,
                'is_locked' => true
            ],
            [
                'name' => 'guest.email',
                'title' => 'Whats your email?',
                'question' => 'Whats your email?',
                'type' => \App\Models\ServiceQuestion::TYPE_TEXT,
                'auth_rule' => \App\Models\ServiceQuestion::AUTH_GUEST,
                'is_required' => true,
                'is_locked' => true
            ],
            [
                'name' => 'guest.phone',
                'title' => 'Whats your phone?',
                'question' => 'Whats your phone?',
                'type' => \App\Models\ServiceQuestion::TYPE_TEXT,
                'auth_rule' => \App\Models\ServiceQuestion::AUTH_GUEST,
                'is_required' => true,
                'is_locked' => true
            ],
        ];

        foreach ($questions as $q) {
            $check = \App\Models\ServiceQuestion::where('name', $q['name'])
                ->where('type', $q['type'])
                ->first();
            if (is_null($check))
                $question = \App\Models\ServiceQuestion::create($q);
        }
    }
}
