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
        Schema::create('job_booking', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_job');
            $table->enum('jenis_job', ['wd', 'rs']);
            $table->decimal('nilai_dp', 15, 2);
            $table->string('nama_catin');
            $table->string('alamat_desa')->nullable();
            $table->integer('alamat_kec_id')->nullable();
            $table->string('alamat_kec')->nullable();
            $table->integer('alamat_kab_id')->nullable();
            $table->string('alamat_kab')->nullable();
            $table->integer('alamat_prov_id')->nullable();
            $table->string('alamat_prov')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->integer('status_job')->default(0)->comment('0=booking, 1=belum tuntas/detail job terisi, 2=tuntas/job selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_booking');
    }
};
