<?php

namespace Database\Seeders;

use App\Models\Decor;
use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DecorSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		foreach (Event::all() as $event) {
			foreach ([1, 2, 3] as $comp) {
				Decor::create(["name" => "$event->name-Decor-0$comp", "file_path" => "pictures/decors/4/decor01.png", "start_use" => now(), "end_use" => now(), "event_id" => $event->id, "validation" => "validated", "user_id" => $event->user->id]);
			}
		}
	}
}
