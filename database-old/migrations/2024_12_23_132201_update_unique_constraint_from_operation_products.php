<?php

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
		Schema::table('operation_products', function (Blueprint $table) {
			$table->dropUnique(['name']);
			$table->unique(['name', 'environment_id'], 'name_environment_id_unique');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('operation_products', function (Blueprint $table) {
			$table->dropUnique('name_environment_id_unique');
			$table->unique('name');
		});
	}
};
