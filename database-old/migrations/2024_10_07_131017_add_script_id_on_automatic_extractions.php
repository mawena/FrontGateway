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
        Schema::table('automatic_extractions', function (Blueprint $table) {
            $table->foreignId("script_id")->default(1)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('automatic_extractions', function (Blueprint $table) {
            $table->dropConstrainedForeignId("script_id");
        });
    }
};
