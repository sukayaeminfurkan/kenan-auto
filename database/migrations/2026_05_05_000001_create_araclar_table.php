<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('araclar', function (Blueprint $table) {
            $table->id();
            $table->string('marka');
            $table->string('model');
            $table->unsignedSmallInteger('yil');
            $table->unsignedInteger('kilometre');
            $table->decimal('fiyat', 12, 2);
            $table->string('renk');
            $table->enum('yakit_turu', ['benzin', 'dizel', 'elektrik', 'hibrit', 'lpg']);
            $table->enum('vites_turu', ['manuel', 'otomatik', 'yari_otomatik']);
            $table->string('kasa_tipi');
            $table->string('motor_hacmi')->nullable();
            $table->unsignedSmallInteger('motor_gucu')->nullable();
            $table->enum('cekis', ['on', 'arka', '4x4'])->default('on');
            $table->enum('durum', ['satilik', 'satildi'])->default('satilik');
            $table->text('aciklama')->nullable();
            $table->json('ozellikler')->nullable();
            $table->string('slug')->unique();
            $table->unsignedInteger('goruntuleme_sayisi')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('araclar');
    }
};
