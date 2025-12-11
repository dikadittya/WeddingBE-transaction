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
            $table->unsignedBigInteger('id_jenis')->nullable()->after('id')->comment('ID referensi ke master jenis item paket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_item_paket', function (Blueprint $table) {
            $table->dropColumn('id_jenis');
        });
    }
};
