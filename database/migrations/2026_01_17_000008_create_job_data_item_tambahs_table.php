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
        Schema::create('job_data_item_tambahs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_job_booking');
            $table->string('item_tambah')->nullable()->comment('Item Tambahan');
            $table->decimal('nilai', 15, 2)->nullable()->comment('Nilai');
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
        Schema::dropIfExists('job_data_item_tambahs');
    }
};
