<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('araclar', function (Blueprint $table) {
            $table->string('yakit_turu', 50)->nullable()->change();
            $table->string('vites_turu', 50)->nullable()->change();
            $table->string('cekis', 50)->nullable()->change();
            $table->string('durum', 50)->default('Satışta')->change();
            $table->unsignedInteger('kilometre')->nullable()->change();
            $table->string('renk')->nullable()->change();
            $table->string('kasa_tipi')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('araclar', function (Blueprint $table) {
            $table->enum('yakit_turu', ['benzin', 'dizel', 'elektrik', 'hibrit', 'lpg'])->nullable(false)->change();
            $table->enum('vites_turu', ['manuel', 'otomatik', 'yari_otomatik'])->nullable(false)->change();
            $table->enum('cekis', ['on', 'arka', '4x4'])->default('on')->nullable(false)->change();
            $table->enum('durum', ['satilik', 'satildi'])->default('satilik')->change();
            $table->unsignedInteger('kilometre')->nullable(false)->change();
            $table->string('renk')->nullable(false)->change();
            $table->string('kasa_tipi')->nullable(false)->change();
        });
    }
};
