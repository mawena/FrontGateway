<?php

namespace Database\Seeders;

use App\Models\Lov;
use App\Models\LovValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LovSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lov = Lov::factory(1)->create(["name" => "Agence"])->first();
        LovValue::factory(1)->create(["lov_id" => $lov->id, "label" => "Siege Kodjoviakopé", "value" => "210"]);
		LovValue::factory(1)->create(["lov_id" => $lov->id, "label" => "Agence Kodjoviakopé", "value" => "211"]);
		LovValue::factory(1)->create(["lov_id" => $lov->id, "label" => "Agence Agouè", "value" => "212"]);
		LovValue::factory(1)->create(["lov_id" => $lov->id, "label" => "Agence Adidogomé", "value" => "213"]);
		LovValue::factory(1)->create(["lov_id" => $lov->id, "label" => "Agence Akodessewa", "value" => "214"]);
        
		$lov = Lov::factory(1)->create(["name" => "Opérations Diverses"])->first();
        LovValue::factory(1)->create(["lov_id" => $lov->id, "label" => "Demande de crédit", "value" => "30000"]);
		LovValue::factory(1)->create(["lov_id" => $lov->id, "label" => "Demande de relevé (1 page)", "value" => "300"]);
    }
}
