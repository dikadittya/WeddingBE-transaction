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
        Schema::create('paket_up', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_up', ['gedung', 'rumahan'])->comment('Jenis UP: gedung atau rumahan');
            $table->unsignedBigInteger('id_jenis_item_paket')->comment('Foreign key ke master_jenis_item_paket');
            $table->string('kode_area', 20)->comment('Kode area/wilayah');
            $table->decimal('nilai_up', 15, 2)->comment('Nilai UP dalam rupiah');
            $table->timestamps();
            
            // // Foreign key constraint
            // $table->foreign('id_jenis_item_paket')
            //       ->references('id')
            //       ->on('master_jenis_item_paket')
            //       ->onDelete('cascade');
                  
            // // Index for better performance
            $table->index(['jenis_up', 'kode_area']);
            $table->index('id_jenis_item_paket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_up');
    }
};
