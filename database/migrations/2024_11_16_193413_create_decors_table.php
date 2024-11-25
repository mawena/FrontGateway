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
		Schema::create('decors', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('file_path');
			$table->date("start_use");
			$table->date("end_use");
			$table->foreignId('event_id')->constrained()->cascadeOnDelete();
			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('decors');
	}
};
