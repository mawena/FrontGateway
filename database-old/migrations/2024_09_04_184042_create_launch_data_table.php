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
        Schema::create('launch_data', function (Blueprint $table) {
            $table->id();
			$table->foreignId("launch_id")->constrained()->cascadeOnDelete();
			$table->foreignId("filter_id")->constrained()->cascadeOnDelete();
			$table->string("value");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('launch_data');
    }
};
