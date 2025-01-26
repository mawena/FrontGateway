<?php

namespace Database\Seeders;

use App\Models\Script;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScriptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Script::factory()->create([
			"name" => "wextractor",
			"file_path" => "upload/scripts/wextractor-script.py",
			"available" => true
		]);
        Script::factory()->create([
			"name" => "Data Bilan Extractor",
			"file_path" => "upload/scripts/data-bilan-extractor-script.py",
			"available" => true
		]);
        Script::factory()->create([
			"name" => "Data Cr Extractor",
			"file_path" => "upload/scripts/data-cr-extractor-script.py",
			"available" => true
		]);
    }
}
