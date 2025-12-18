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
        Schema::table('master_item_paket', function (Blueprint $table) {
            $table->dropColumn('kategori_paket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_item_paket', function (Blueprint $table) {
            $table->enum('kategori_paket', ['gedung', 'rumahan'])->comment('Kategori paket: gedung atau rumahan')->after('nama_item');
        });
    }
};
