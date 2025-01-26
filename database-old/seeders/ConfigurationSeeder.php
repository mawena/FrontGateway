<?php

namespace Database\Seeders;

use App\Models\Configuration;
use App\Models\Environment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		foreach (Environment::all() as $environment) {
			Configuration::factory()->create(["line" => 1, "name" => "Name", "value" => "Tmp", "sheet" => "group_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "Subject", "value" => "Extraction Journalières Flexcube de Gestion du :j-1", "sheet" => "group_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "MessageContent", "value" => "Bonjour Chers tous,
	
	Les Extractions Flexcube du :j-1 sont disponible en pièce-jointe et dans le dossier partagé(ReportFlex):
	
	:files
	:shared_files
	
	Regard
	
	Si vous avez besoin des extractions  spécifiques qui ne sont pas incluses dans nos extractions automatiques,
	N'hésitez pas à nous envoyer un modèle afin que nous puissions rédiger une nouvelle requête adapté à votre demande.", "sheet" => "group_conf", "environment_id" => $environment->id]);

			Configuration::factory()->create(["line" => 1, "name" => "Host", "value" => "105.235.116.186", "sheet" => "vpn_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "Port", "value" => "25443", "sheet" => "vpn_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "User", "value" => "togo", "sheet" => "vpn_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "Password", "value" => "Tog@@2024!", "sheet" => "vpn_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "Certificate", "value" => "4abeab3b0cfcd556817a86b9d62dce79d91eba3a930fc3632bf4501f0496d366", "sheet" => "vpn_conf", "environment_id" => $environment->id]);

			Configuration::factory()->create(["line" => 1, "name" => "ServerAddress", "value" => "10.25.50.60", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "ServerPort", "value" => "1521", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "serviceName", "value" => "FCPZ1PDB.cofinaonline.com", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "User", "value" => "CFSFCUBS145", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "Password", "value" => "bZnfm_TWqiLC#Mhe8B4j", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "MaxSimultaneousConnection", "value" => "5", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "MaxRow", "value" => "1048576", "sheet" => "db_conf", "environment_id" => $environment->id]);

			Configuration::factory()->create(["line" => 2, "name" => "ServerAddress", "value" => "127.0.0.1", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 2, "name" => "ServerPort", "value" => "1521", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 2, "name" => "serviceName", "value" => "xe", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 2, "name" => "User", "value" => "COFINA_CREDIT", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 2, "name" => "Password", "value" => "Coftg2021", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 2, "name" => "MaxSimultaneousConnection", "value" => "5", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 2, "name" => "MaxRow", "value" => "1048576", "sheet" => "db_conf", "environment_id" => $environment->id]);

			Configuration::factory()->create(["line" => 3, "name" => "ServerAddress", "value" => "127.0.0.1", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 3, "name" => "ServerPort", "value" => "1522", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 3, "name" => "serviceName", "value" => "xe", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 3, "name" => "User", "value" => "FLEXCUBE_TEST", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 3, "name" => "Password", "value" => "Coftg2021", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 3, "name" => "MaxSimultaneousConnection", "value" => "5", "sheet" => "db_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 3, "name" => "MaxRow", "value" => "1048576", "sheet" => "db_conf", "environment_id" => $environment->id]);

			Configuration::factory()->create(["line" => 1, "name" => "SmtpServerAddress", "value" => "smtp.office365.com", "sheet" => "email_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "SmtpPort", "value" => "587", "sheet" => "email_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "SenderEmail", "value" => "report_tg@cofinacorp.com", "sheet" => "email_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "SenderPassword", "value" => "COFINatogo2021", "sheet" => "email_conf", "environment_id" => $environment->id]);

			Configuration::factory()->create(["line" => 1, "name" => "Server", "value" => "10.228.50.12", "sheet" => "share_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "ShareName", "value" => "ReportFlex", "sheet" => "share_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "User", "value" => "Administrateur", "sheet" => "share_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "Password", "value" => "Coftg@20$*1212", "sheet" => "share_conf", "environment_id" => $environment->id]);

			Configuration::factory()->create(["line" => 1, "name" => "ServerAddress", "value" => "127.0.0.1", "sheet" => "ws_launch_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "Port", "value" => "8765", "sheet" => "ws_launch_conf", "environment_id" => $environment->id]);

			Configuration::factory()->create(["line" => 1, "name" => "ServerAddress", "value" => "127.0.0.1", "sheet" => "ws_service_conf", "environment_id" => $environment->id]);
			Configuration::factory()->create(["line" => 1, "name" => "Port", "value" => "9876", "sheet" => "ws_service_conf", "environment_id" => $environment->id]);

			Configuration::factory()->create(["line" => 1, "name" => "ServerAddress", "value" => "https://report-tg.cofinaonline.com", "sheet" => "local_server", "environment_id" => $environment->id]);
		}
	}
}
