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
			$table->strint("contact");
			$table->timestamps();
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->text('description')->nullable();
			$table->text('description_summary');
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
