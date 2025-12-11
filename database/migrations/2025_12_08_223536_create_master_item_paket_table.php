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
        Schema::create('master_item_paket', function (Blueprint $table) {
            $table->id();
            $table->string('nama_item')->comment('Nama item paket');
            $table->enum('kategori_paket', ['gedung', 'rumahan'])->comment('Kategori paket: gedung atau rumahan');
            $table->enum('tipe', ['reguler', 'khusus'])->comment('Tipe paket: reguler atau khusus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_item_paket');
    }
};
