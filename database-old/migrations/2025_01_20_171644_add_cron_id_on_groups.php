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
        Schema::table('automatic_extraction_groups', function (Blueprint $table) {
            $table->string("cron_id")->default('daily');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('automatic_extraction_groups', function (Blueprint $table) {
            $table->dropColumn("cron_id");
        });
    }
};
