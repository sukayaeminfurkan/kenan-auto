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
        Schema::create('modeller', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marka_id')->constrained('markalar')->cascadeOnDelete();
            $table->string('ad');
            $table->string('slug');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
            $table->unique(['marka_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modeller');
    }
};
