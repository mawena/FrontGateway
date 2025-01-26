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
        Schema::create('operation_products', function (Blueprint $table) {
            $table->id();
			$table->string("name")->unique();
			$table->decimal("unit_price");
			$table->string("ht_account_no");
			$table->string("ht_operation_code");
			$table->string("ht_erc_libelle");
			$table->string("taf_account_no");
			$table->string("taf_operation_code");
			$table->string("taf_erc_libelle");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operation_products');
    }
};
