<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arac_talepler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arac_id')->nullable()->constrained('araclar')->nullOnDelete();
            $table->string('ad');
            $table->string('soyad');
            $table->string('telefon', 20);
            $table->string('email')->nullable();
            $table->text('mesaj')->nullable();
            $table->enum('durum', ['beklemede', 'incelendi', 'tamamlandi', 'iptal'])->default('beklemede');
            $table->text('notlar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arac_talepler');
    }
};
