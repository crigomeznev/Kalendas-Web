<?php

namespace Database\Seeders;

use App\Models\Calendar;
use App\Models\Target;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Target::create([
            'name' => 'Pare',
            'email' => 'cgomezpruebas@gmail.com',
            'calendar_id' => Calendar::where('owner_id', User::where('email', 'cgomez@milaifontanals.org')->first()->id)->first()->id
        ]);

    }
}
