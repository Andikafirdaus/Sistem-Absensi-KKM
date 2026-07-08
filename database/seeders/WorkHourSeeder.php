<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WorkHour;

class WorkHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkHour::create([
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'late_tolerance' => 15,
        ]);
    }
}
