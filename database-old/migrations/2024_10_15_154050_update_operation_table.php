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
        Schema::table('operations', function (Blueprint $table) {
            $table->dropConstrainedForeignId("lov_value_id");
            $table->dropColumn("lov_value_value");
			$table->foreignId("operation_product_id")->default(1)->constrained(indexName:"o_o_p_i")->cascadeOnDelete();
			$table->decimal("operation_product_unit_price");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operations', function (Blueprint $table) {
			$table->dropForeign("o_o_p_i");
			$table->dropColumn("operation_product_id");
			$table->dropColumn("operation_product_unit_price");
			$table->foreignId("lov_value_id")->default(1)->constrained()->cascadeOnDelete();
			$table->decimal("lov_value_value")->default(value: 0);
        });
    }
};
