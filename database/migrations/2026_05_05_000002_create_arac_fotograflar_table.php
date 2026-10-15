<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arac_fotograflar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arac_id')->constrained('araclar')->cascadeOnDelete();
            $table->string('dosya_yolu');
            $table->string('alt_metin')->nullable();
            $table->unsignedTinyInteger('sira')->default(0);
            $table->boolean('kapak')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arac_fotograflar');
    }
};
