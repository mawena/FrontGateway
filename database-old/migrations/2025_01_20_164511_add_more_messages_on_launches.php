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
        Schema::table('launches', function (Blueprint $table) {
            $table->string("success_mesage")->nullable();
			$table->string("warning_mesage")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('launches', function (Blueprint $table) {
			$table->dropColumn("success_mesage");
			$table->dropColumn("warning_mesage");
        });
    }
};
