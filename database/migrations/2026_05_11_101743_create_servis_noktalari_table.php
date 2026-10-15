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
        Schema::create('servis_noktalari', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('sehir')->nullable();
            $table->string('kategori')->nullable();
            $table->string('logo')->nullable();
            $table->integer('sira')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servis_noktalari');
    }
};
