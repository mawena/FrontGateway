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
        Schema::table('extractions', function (Blueprint $table) {
			$table->dropForeign("extractions_department_id_foreign");
			$table->dropColumn("department_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extractions', function (Blueprint $table) {
			$table->foreignId('department_id')->default(1)->constrained()->cascadeOnDelete();
        });
    }
};
