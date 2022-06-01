<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Calendar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Activity::create([
            'title' => 'Visita al museu de la pell',
            'description' => 'Jornada de matí en el museu de la pell d\'Igualada',

            'latitude' => 41.576880,
            'longitude' =>  1.613541,

            'begin_time' => date_create('2022-05-24'),
            'end_time' => date_create('2022-05-28'),

            'calendar_id' => Calendar::where('owner_id', User::where('email', 'cgomez@milaifontanals.org')->first()->id)->first()->id
        ]);
    }
}
