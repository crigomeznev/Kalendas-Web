<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Calendar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subscription::create([
            'user_id' => User::where('email', 'rafi@nature.com')->first()->id,
            'calendar_id' => Calendar::where('owner_id', User::where('email', 'cgomez@milaifontanals.org')->first()->id)->first()->id
        ]);
    }
}
