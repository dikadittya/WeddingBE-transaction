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
        Schema::create('job_data_makeups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_job_booking');
            $table->string('jenis_makeup')->nullable()->comment('Jenis Makeup');
            $table->string('busana_akad_perempuan')->nullable()->comment('Busana Akad Perempuan');
            $table->string('busana_akad_laki')->nullable()->comment('Busana Akad Laki-laki');
            $table->string('busana_temu_perempuan')->nullable()->comment('Busana Temu Perempuan');
            $table->string('busana_temu_laki')->nullable()->comment('Busana Temu Laki-laki');
            $table->string('busana_ganti_perempuan')->nullable()->comment('Busana Ganti Perempuan');
            $table->string('busana_ganti_laki')->nullable()->comment('Busana Ganti Laki-laki');
            $table->string('bunga_melati')->nullable()->comment('Bunga Melati');
            $table->text('catatan_makeup')->nullable()->comment('Catatan Makeup');
            $table->string('mua_nikah')->nullable()->comment('MUA Nikah');
            $table->string('mua_resepsi')->nullable()->comment('MUA Resepsi');
            $table->string('asisten_nikah')->nullable()->comment('Asisten Nikah');
            $table->string('asisten_resepsi')->nullable()->comment('Asisten Resepsi');
            $table->text('tambahan_gown')->nullable()->comment('Tambahan Gown - format json sesuai kebutuhan');
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
        Schema::dropIfExists('job_data_makeups');
    }
};
