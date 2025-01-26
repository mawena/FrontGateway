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
        Schema::table('users', function (Blueprint $table) {
			$table->dropUnique('users_flexcube_user_id_unique'); // Remplacez par le nom exact de l'index
			$table->string('flexcube_user_id')->nullable()->change();
        });
    }
	
    /**
	 * Reverse the migrations.
     */
	public function down(): void
    {
		Schema::table('users', function (Blueprint $table) {
			$table->unique('flexcube_user_id'); // Remettez l'unicité si nécessaire lors d'un rollback
			$table->string('flexcube_user_id')->nullable(false)->change();
        });
    }
};
