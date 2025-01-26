<?php

namespace Database\Seeders;

use App\Models\Launch;
use App\Models\LaunchData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaunchSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		foreach(["manual", "automatic"] as $type){
			foreach (["requested", "in-treatment", "failed", "successful"] as $status) {
				$launch = Launch::factory()->create(["extraction_id" => 1, "status" => $status, "type" => $type, "launcher_id" => 1])->first();
				// LaunchData::factory()->create(["launch_id" => $launch->id, "filter_id" => 1, "value" => "2024-09-09",]);
				// LaunchData::factory()->create(["launch_id" => $launch->id, "filter_id" => 2, "value" => "25/09/2024",]);
			}
		}
	}
}
