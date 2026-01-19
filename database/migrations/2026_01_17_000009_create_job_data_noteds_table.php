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
        Schema::create('job_data_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_job_booking');
            $table->string('tipe_note')->nullable()->comment('Tipe Noted: keterangan, catatan');
            $table->text('isi_note')->nullable()->comment('Isi Noted');
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
        Schema::dropIfExists('job_data_notes');
    }
};
