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
        Schema::create('job_data_pengantins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_job_booking');
            $table->string('nama_mua')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('waktu_job', ['p', 's', 'm'])->nullable()->comment('p=pagi, s=siang, m=malam');
            $table->time('waktu_job_jam')->nullable();
            $table->enum('waktu_temu', ['p', 's', 'm'])->nullable()->comment('p=pagi, s=siang, m=malam');
            $table->time('waktu_temu_jam')->nullable();
            $table->enum('waktu_resepsi', ['p', 's', 'm'])->nullable()->comment('p=pagi, s=siang, m=malam');
            $table->time('waktu_resepsi_jam')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('medsos')->nullable();
            $table->text('alamat_resepsi')->nullable();
            $table->text('alamat_akad')->nullable();
            $table->text('petunjuk_arah')->nullable();
            $table->string('url_map_resepsi')->nullable();
            $table->string('url_map_akad')->nullable();
            $table->string('nama_ortu')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_job_booking')
                  ->references('id')
                  ->on('job_bookings')
                  ->onDelete('cascade');
            
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_data_pengantins');
    }
};
