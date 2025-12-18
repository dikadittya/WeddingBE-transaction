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
        Schema::create('paket_master', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mua')->constrained('master_mua')->onDelete('cascade')->comment('ID MUA');
            $table->string('nama_paket')->comment('Nama paket');
            $table->enum('jenis_paket', ['gedung', 'rumahan'])->comment('Jenis paket: gedung atau rumahan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_master');
    }
};
