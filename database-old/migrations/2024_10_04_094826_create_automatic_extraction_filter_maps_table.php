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
        Schema::create('automatic_extraction_filter_maps', function (Blueprint $table) {
            $table->id();
			$table->foreignId("automatic_extraction_id")->constrained()->cascadeOnDelete();
			$table->foreignId("filter_id")->constrained()->cascadeOnDelete();
			$table->string("value");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('automatic_extraction_filter_maps');
    }
};
