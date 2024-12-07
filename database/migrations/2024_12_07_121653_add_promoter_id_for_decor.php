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
		Schema::table('decors', function (Blueprint $table) {
			$table->foreignId('promoter_id')->default(1)->constrained()->cascadeOnDelete();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('decors', function (Blueprint $table) {
			$table->dropForeign(['promoter_id']); // Supprime la contrainte étrangère
			$table->dropColumn('promoter_id');   // Supprime la colonne
		});
	}
};
