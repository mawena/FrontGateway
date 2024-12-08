<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		foreach ([1, 2, 3] as $comp) {
			foreach (User::where('profile', 'promoter')->get() as $promoter) {
				Event::factory(1)->create(["name" => "Event-promoter-$promoter->id-$comp", "start_date" => now(), "end_date" => now(), "user_id" => $promoter->id, "place" => "Lomé", "type" => "Concert", "nb_expected" => 15, "entrance" => "paid", "entry_price" => 500, "contact" => "0228 90 90 90 90", "poster_path" => "pictures/events/hiver-togo.png", "validation" => "validated"]);
			}
			foreach (User::where('profile', 'supervisor')->get() as $supervisor) {
				Event::factory(1)->create(["name" => "Event-supervisor-$supervisor->id-$comp", "start_date" => now(), "end_date" => now(), "user_id" => $supervisor->id, "place" => "Lomé", "type" => "Concert", "nb_expected" => 15, "entrance" => "paid", "entry_price" => 500, "contact" => "0228 90 90 90 90", "poster_path" => "pictures/events/hiver-togo.png", "validation" => "validated"]);
			}
		}
	}
}
