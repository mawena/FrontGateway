<?php

namespace Database\Seeders;

use App\Models\TaskSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaskSchedule::factory()->create(["name" => "test","days" => ["monday", "thursday", "friday"],"time" => "15:05","command" => "echo 'dumsa'"]);
    }
}
