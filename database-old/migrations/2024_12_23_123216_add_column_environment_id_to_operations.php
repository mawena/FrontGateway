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
		$defaultEnvironment = Environment::where("name", "Togo")->first();
		Schema::table('operations', function (Blueprint $table) use ($defaultEnvironment) {
			$table->foreignId("environment_id")->default($defaultEnvironment->id ?? 1)->constrained()->cascadeOnDelete();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('operations', function (Blueprint $table) {
			$table->dropConstrainedForeignId("environment_id");
		});
	}
};
