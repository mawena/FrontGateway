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
        Schema::create('automatic_extraction_groups', function (Blueprint $table) {
            $table->id();
			$table->string("name");
			$table->boolean("active");
			$table->string("mail_subject");
			$table->text("mail_content");
			$table->json("receivers_mail");
			$table->json("receivers_cc_mail");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('automatic_extraction_groups');
    }
};
