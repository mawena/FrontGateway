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
		Schema::create('automatic_extractions', function (Blueprint $table) {
			$table->id();
			$table->string("name")->unique();
			$table->foreignId("automatic_extraction_group_id")->constrained(indexName: "a_e__a_e_g_id")->cascadeOnDelete();
			$table->foreignId("extraction_id")->constrained()->cascadeOnDelete();
			$table->boolean('active');
			$table->unique(["automatic_extraction_group_id", "extraction_id"], "a_e_g_i__e_i");
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('automatic_extractions');
	}
};
