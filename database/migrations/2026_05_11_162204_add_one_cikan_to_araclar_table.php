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
        Schema::table('araclar', function (Blueprint $table) {
            $table->boolean('one_cikan')->default(false)->after('aktif');
            $table->integer('sira')->default(0)->after('one_cikan');
        });
    }

    public function down(): void
    {
        Schema::table('araclar', function (Blueprint $table) {
            $table->dropColumn(['one_cikan', 'sira']);
        });
    }
};
