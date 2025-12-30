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
        Schema::create('job_data_pakets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_job_booking');
            $table->decimal('tambahan_dp', 15, 2)->default(0)->comment('Tambahan Down Payment');
            $table->decimal('nilai_paket', 15, 2)->default(0)->comment('Nilai Paket');
            $table->decimal('nilai_dp', 15, 2)->default(0)->comment('Nilai Down Payment');
            $table->decimal('nilai_tambahan_item', 15, 2)->default(0)->comment('Nilai Tambahan Item');
            $table->decimal('sisa_bayar', 15, 2)->default(0)->comment('Sisa Pembayaran');
            $table->text('catatan_paket')->nullable()->comment('Catatan Paket');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_job_booking')
                  ->references('id')
                  ->on('job_bookings')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_data_pakets');
    }
};
