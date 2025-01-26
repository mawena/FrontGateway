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
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
			$table->foreignId("user_id")->constrained()->cascadeOnDelete();
			$table->foreignId("lov_value_id")->constrained()->cascadeOnDelete();
			$table->decimal("lov_value_value");
			$table->integer("quantity");
			$table->string("customer_account_number");
			$table->enum("status", ["requested", "in-treatment", "validated", "insufficient-balance", "failed"]);
			$table->text("message")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operations');
    }
};
