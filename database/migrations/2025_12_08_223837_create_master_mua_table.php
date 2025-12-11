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
        Schema::create('master_mua', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mua')->comment('Nama MUA');
            $table->boolean('is_vendor')->default(0)->comment('Status vendor: 1 = vendor, 0 = bukan vendor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_mua');
    }
};
