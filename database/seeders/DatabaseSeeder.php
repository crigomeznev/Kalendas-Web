<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountrySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CalendarSeeder::class);
        $this->call(ActivitySeeder::class);
        $this->call(TargetSeeder::class);
        $this->call(SubscriptionSeeder::class);
    }
}
