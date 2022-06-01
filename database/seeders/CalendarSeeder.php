<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Calendar;
use App\Models\User;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Calendar::create([
            'title' => 'Cristian\'s calendar',
            'owner_id' => User::where('email', 'cgomez@milaifontanals.org')->first()->id
        ]);
    }
}
