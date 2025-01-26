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
		Schema::create('extractions', function (Blueprint $table) {
			$table->id();
			$table->foreignId('department_id')->constrained()->cascadeOnDelete();
			$table->string("name");
			$table->boolean("need_agency")->default(false);
			$table->text("sql_script");
			$table->timestamps();
			$table->unique(["department_id", "name"]);
			$table->foreignId("script_id")->constrained()->cascadeOnDelete();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('extractions');
	}
};
