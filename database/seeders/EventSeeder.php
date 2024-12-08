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
		foreach (User::where('profile', 'promoter')->get() as $promoter) {
			foreach ([1, 2, 3] as $comp) {
				Event::factory(1)->create(["name" => "$promoter->name-Event-0$comp", "start_date" => now(), "end_date" => now(), "user_id" => $promoter->id, "place" => "Lomé", "type" => "Concert", "nb_expected" => 15, "entrance" => "paid", "entry_price" => 500, "contact" => "0228 90 90 90 90", "poster_path" => "pictures/events/hiver-togo.png", "validation" => "validated"]);
			}
		}
		foreach (User::where('profile', 'supervisor')->get() as $supervisor) {
			foreach ([1, 2, 3] as $comp) {
				Event::factory(1)->create(["name" => "$supervisor->name-Event-0$comp", "start_date" => now(), "end_date" => now(), "user_id" => $supervisor->id, "place" => "Lomé", "type" => "Concert", "nb_expected" => 15, "entrance" => "paid", "entry_price" => 500, "contact" => "0228 90 90 90 90", "poster_path" => "pictures/events/hiver-togo.png", "validation" => "validated"]);
			}
		}
	}
}
