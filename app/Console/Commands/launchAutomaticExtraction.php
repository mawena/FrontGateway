<?php

namespace App\Console\Commands;

use App\Jobs\ExecuteShellCommand;
use App\Models\AutomaticExtractionGroup;
use Illuminate\Console\Command;

class launchAutomaticExtraction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:lae {cron_id*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commandes qui permet de lancer des groupes d\'extraction automatiques à partir de la clé cron';

    /**
     * Execute the console command.
     */
    public function handle()
    {
		foreach($this->argument('cron_id') as $cron_id){
			$automaticExtractionGroupList = AutomaticExtractionGroup::where("active", true)->where('cron_id', $cron_id)->get();
			foreach ($automaticExtractionGroupList as $automaticExtractionGroup) {
				$script_file_path = $automaticExtractionGroup->script->file_path;
				$filename = basename($script_file_path);
				ExecuteShellCommand::dispatch([".venv/bin/python3", $filename, $automaticExtractionGroup->id]);
			}
		}
    }
}
