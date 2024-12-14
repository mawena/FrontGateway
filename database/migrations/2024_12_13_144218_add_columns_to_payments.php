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
        Schema::table('payments', function (Blueprint $table) {
            $table->string("phone_number");
            $table->string("payment_token")->nullable();
            $table->string("payment_url")->nullable();
            $table->string("transaction_id")->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn("phone_number");
            $table->dropColumn("payment_token");
            $table->dropColumn("payment_url");
            $table->dropColumn("transaction_id");
        });
    }
};
