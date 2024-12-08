<?php

namespace Database\Seeders;

use App\Models\Promoter;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoterSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		foreach (User::where('profile', 'promoter')->get() as $promoter) {
			Promoter::create(["structure" => "Structure-$promoter->name", "phone_number" => "0228 91 91 91 91", "birth_date" => now(), "sex" => "M", "user_id" => $promoter->id]);
		}
	}
}
