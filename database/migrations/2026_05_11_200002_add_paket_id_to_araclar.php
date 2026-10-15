<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('araclar', function (Blueprint $table) {
            $table->foreignId('paket_id')->nullable()->after('model_id')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('araclar', function (Blueprint $table) {
            $table->dropForeign(['paket_id']);
            $table->dropColumn('paket_id');
        });
    }
};
