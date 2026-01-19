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
        Schema::table('job_data_pakets', function (Blueprint $table) {
            $table->string('set_pendamping')->nullable()->after('catatan_paket')->comment('Set Pendamping');
            $table->string('dekorasi_kode')->nullable()->after('set_pendamping')->comment('Kode Dekorasi');
            $table->string('dekorasi_tw')->nullable()->after('dekorasi_kode')->comment('Nama TW Dekorasi');
            $table->string('dekorasi_admin')->nullable()->after('dekorasi_tw')->comment('Admin Dekorasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_data_pakets', function (Blueprint $table) {
            $table->dropColumn(['set_pendamping', 'dekorasi_kode', 'dekorasi_tw', 'dekorasi_admin']);
        });
    }
};
