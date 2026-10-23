<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('periksa', function (Blueprint $table) {
            $table->string('bukti_bayar')->nullable()->after('biaya_periksa');
            $table->enum('status_bayar', ['Belum Dibayar', 'Menunggu Verifikasi', 'Lunas'])
                  ->default('Belum Dibayar')
                  ->after('bukti_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('periksa', function (Blueprint $table) {
            $table->dropColumn(['bukti_bayar', 'status_bayar']);
        });
    }
};
