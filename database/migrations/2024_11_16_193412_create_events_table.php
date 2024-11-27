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
		Schema::create('events', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->dateTime('start_date');
			$table->dateTime('end_date');
			$table->string("place");
			$table->string("type");
			$table->integer("nb_expected");
			$table->enum("entrance", ["free", "paid"]);
			$table->float("entry_price")->nullable();
			$table->string("contact");
			$table->timestamps();
			$table->foreignId('promoter_id')->constrained()->cascadeOnDelete();
			$table->text('description')->nullable();
			$table->text('description_summary');
			$table->string("poster_path");
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('events');
	}
};
