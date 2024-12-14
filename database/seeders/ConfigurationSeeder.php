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
        Configuration::create(["key" => "Token API", "value" => "928662274675c069963aab7.58937288"]);
        Configuration::create(["key" => "Lien API POST", "value" => "https://api-checkout.cinetpay.com/v2/payment"]);
        Configuration::create(["key" => "Lien API Callback", "value" => "https://pecorator.chawena.com/api/payment/callback"]);
        Configuration::create(["key" => "API SITE_SID", "value" => "5884195"]);
        Configuration::create(["key" => "API SECRET_KEY", "value" => "1261551590675c0763b702c3.64362583"]);
        Configuration::create(["key" => "Le lien de retour", "value" => "https://pecorator.chawena.com/admin/payment"]);
    }
}
