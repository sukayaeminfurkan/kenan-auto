<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paketler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id')->constrained('modeller')->cascadeOnDelete();
            $table->string('ad');
            $table->string('yakit_turu')->nullable();
            $table->string('vites_turu')->nullable();
            $table->string('motor_hacmi')->nullable();
            $table->integer('motor_gucu')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paketler');
    }
};
