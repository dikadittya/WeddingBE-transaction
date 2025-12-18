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
        Schema::create('paket_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_paket_master')->constrained('paket_master')->onDelete('cascade')->comment('ID Master Paket');
            $table->foreignId('id_master_item_paket')->constrained('master_item_paket')->onDelete('cascade')->comment('ID Master Item Paket');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_items');
    }
};