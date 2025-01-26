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
		Schema::table('automatic_extractions', function (Blueprint $table) {
			$table->dropForeign('a_e__a_e_g_id'); // Supprimer la clé unique
			$table->dropForeign('automatic_extractions_extraction_id_foreign'); // Supprimer la clé unique

			$table->dropUnique("automatic_extractions_name_unique");
			$table->dropUnique("a_e_g_i__e_i");

			$table->foreign('automatic_extraction_group_id')->references('id')->on('automatic_extraction_groups')->onDelete('cascade');
			$table->foreign('extraction_id')->references('id')->on('extractions')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('automatic_extractions', function (Blueprint $table) {});
	}
};
