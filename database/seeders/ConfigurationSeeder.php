<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Configuration::create(["key" => "Prix Unitaire", "value" => "25"]);
        Configuration::create(["key" => "Token API", "value" => ""]);
        Configuration::create(["key" => "Lien API POST", "value" => ""]);
        Configuration::create(["key" => "Lien API Callback", "value" => ""]);
        Configuration::create(["key" => "API SITE_SID", "value" => ""]);
        Configuration::create(["key" => "Le lien de retour", "value" => ""]);
    }
}
