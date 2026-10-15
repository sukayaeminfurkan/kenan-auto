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
            $table->string('baslik')->nullable()->after('model');
        });
    }

    public function down(): void
    {
        Schema::table('araclar', function (Blueprint $table) {
            $table->dropColumn('baslik');
        });
    }
};
