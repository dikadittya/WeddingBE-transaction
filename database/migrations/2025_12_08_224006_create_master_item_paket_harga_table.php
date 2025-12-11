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
        Schema::create('master_item_paket_harga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_master_item_paket')->comment('ID referensi ke master item paket');
            $table->decimal('harga', 15, 2)->comment('Harga item paket');
            $table->unsignedBigInteger('id_master_mua')->comment('ID referensi ke master MUA');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_item_paket_harga');
    }
};
