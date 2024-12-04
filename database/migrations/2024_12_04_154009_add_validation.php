<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::table('events', function (Blueprint $table) {
			$table->enum('validation', ['rejected', 'pending', 'validated'])->default('pending');
		});


		Schema::table('decors', function (Blueprint $table) {
			$table->enum('validation', ['rejected', 'pending', 'validated'])->default('pending');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('events', function (Blueprint $table) {
			$table->dropColumn('validation');
		});

		Schema::table('decors', function (Blueprint $table) {
			$table->dropColumn('validation');
		});
	}
};
