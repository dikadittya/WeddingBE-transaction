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
        Schema::create('job_data_item_properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_job_booking');
            $table->string('item_property')->nullable()->comment('Item Property');
            $table->integer('volume')->nullable()->comment('Volume');
            $table->string('satuan')->nullable()->comment('Satuan');
            $table->string('property_tw')->nullable()->comment('Property TW');
            $table->string('property_admin')->nullable()->comment('Property Admin');
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
        Schema::dropIfExists('job_data_item_properties');
    }
};
