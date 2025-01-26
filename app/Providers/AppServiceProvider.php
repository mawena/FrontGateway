<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
		Blade::if('can', function ($actions, $subject, $connectedUser=null) {
			if($connectedUser){
				foreach ($connectedUser["ability_rules"] as $rules) {
					if (in_array($subject, $rules["subject"]) || in_array("all", $rules["subject"])) {
						if (in_array("manage", $rules["action"])) {
							return true;
						}
						foreach ($actions as $action) {
							if (in_array($action, $rules["action"]))
								return true;
						}
					}
				}
			}
			return false;
		});
    }
}
