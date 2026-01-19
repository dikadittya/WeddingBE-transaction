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
        Schema::create('job_data_item_dokumentasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_job_booking');
            $table->string('item_dokumentasi')->nullable()->comment('Item Dokumentasi');
            $table->integer('volume')->nullable()->comment('Volume');
            $table->string('dokumentasi_tw')->nullable()->comment('Dokumentasi TW');
            $table->string('dokumentasi_admin')->nullable()->comment('Dokumentasi Admin');
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
        Schema::dropIfExists('job_data_item_dokumentasis');
    }
};
