<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		// \App\Models\User::factory(10)->create();

		// \App\Models\User::factory()->create([
		//     'name' => 'Test User',
		//     'email' => 'test@example.com',
		// ]);

		$this->call(ScriptSeeder::class);
		$this->call(LovSeeder::class);
		$this->call(DepartmentSeeder::class);
		$this->call(UserSeeder::class);
		$this->call(TaskScheduleSeeder::class);
		$this->call(EnvironmentSeeder::class);
		$this->call(ConfigurationSeeder::class);
		$this->call(ServiceSeeder::class);
		// $this->call(LaunchSeeder::class);
	}
}
