<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::factory(1)->create([
			"name" => "Service index WS",
			"description" => "Serveur WebSocket pour gérer la page index des services",
			"file_path" => "upload/scripts/service-index-ws-service.py",
			"status" => "off",
		]);
		Service::factory(1)->create([
			"name" => "Launch index WS",
			"description" => "Serveur WebSocket pour gérer la page index des lancements",
			"file_path" => "upload/scripts/launch-index-ws-service.py",
			"status" => "off",
		]);
        Service::factory(1)->create([
			"name" => "VPN Launcher Bot",
			"description" => "Bot pour gérer la connexion au vpn",
			"file_path" => "upload/scripts/vpn-launcher-bot-service.py",
			"status" => "off",
		]);
        Service::factory(1)->create([
			"name" => "Manual VPN Launcher",
			"description" => "Service pour lancer la connexion au vpn manuelement",
			"file_path" => "upload/scripts/manual-vpn-launcher-service.py",
			"status" => "off",
		]);
    }
}