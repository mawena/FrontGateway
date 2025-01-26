<?php

use App\Models\Environment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		$defaultEnvironment = Environment::create(["name" => "Togo"]);
		Schema::table('configurations', function (Blueprint $table) use ($defaultEnvironment) {
			$table->foreignId("environment_id")->default($defaultEnvironment->id)->constrained()->cascadeOnDelete();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('configurations', function (Blueprint $table) {
			$table->dropConstrainedForeignId("environment_id");
		});
		$defaultEnvironment = Environment::where("name", "Togo")->first();
		$defaultEnvironment->delete();
	}
};
