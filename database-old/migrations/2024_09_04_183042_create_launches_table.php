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
		Schema::create('launches', function (Blueprint $table) {
			$table->id();
			$table->foreignId("extraction_id")->constrained()->cascadeOnDelete();
			$table->enum("status", ["requested", "in-treatment", "failed", "successful"]);
			$table->enum("type", ["manual", "automatic"]);
			$table->text("file_path")->nullable();
			$table->foreignId("launcher_id")->constrained(table: "users", column: "id")->cascadeOnDelete();
			$table->text("error_message")->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('launches');
	}
};
