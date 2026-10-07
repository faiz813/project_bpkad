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
        Schema::table('tamus', function (Blueprint $table) {
            $table->string('bidang')->nullable()->after('tujuan_lainnya');
            $table->string('status_kunjungan')->default('Aktif')->after('tanda_tangan');
            $table->timestamp('checkout_at')->nullable()->after('status_kunjungan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tamus', function (Blueprint $table) {
            $table->dropColumn(['bidang', 'status_kunjungan', 'checkout_at']);
        });
    }
};
