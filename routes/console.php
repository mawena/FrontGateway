<?php

use App\Jobs\ExecuteShellCommand;
use App\Models\AutomaticExtractionGroup;
use App\Models\Environment;
use App\Models\Extraction;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/


// Artisan::command('launch-automatic:all', function () {
// 	$automaticExtractionGroupList = AutomaticExtractionGroup::where("active", true)->get();
// 	foreach ($automaticExtractionGroupList as $automaticExtractionGroup) {
// 		$script_file_path = $automaticExtractionGroup->script->file_path;
// 		$filename = basename($script_file_path);
// 		ExecuteShellCommand::dispatch([".venv/bin/python3", $filename, $automaticExtractionGroup->id]);
// 	}
// });

Artisan::command("launch:archive", function () {
	DB::update("update launches set archiving='archived';");
});

// Artisan::command("togo:associate", function () {
// 	$defaultEnvironment = Environment::where("name", "Togo")->first();
// 	foreach (User::all() as $user) {
// 		$user->environments()->sync([$defaultEnvironment->id]);
// 	}
// 	foreach (Extraction::all() as $extraction) {
// 		$extraction->environments()->sync([$defaultEnvironment->id]);
// 	}
// });
