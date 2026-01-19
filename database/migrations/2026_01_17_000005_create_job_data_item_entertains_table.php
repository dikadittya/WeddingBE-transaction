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
        Schema::create('job_data_item_entertains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_job_booking');
            $table->string('item_entertain')->nullable()->comment('Item Entertain');
            $table->integer('volume')->nullable()->comment('Volume');
            $table->string('entertain_tw')->nullable()->comment('Entertain TW');
            $table->string('entertain_admin')->nullable()->comment('Entertain Admin');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_job_booking')
                  ->references('id')
                  ->on('job_booking')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_data_item_entertains');
    }
};
