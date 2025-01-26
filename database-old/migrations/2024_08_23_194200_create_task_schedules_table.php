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
		Schema::create('task_schedules', function (Blueprint $table) {
			$table->id();
			$table->string("name");
			$table->json("days")->nullable();
			$table->time("time");
			$table->text("command");
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('task_schedules');
	}
};
