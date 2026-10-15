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
            $table->dropColumn(['marka', 'model']);
            $table->foreignId('marka_id')->nullable()->after('id')->constrained('markalar')->nullOnDelete();
            $table->foreignId('model_id')->nullable()->after('marka_id')->constrained('modeller')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('araclar', function (Blueprint $table) {
            $table->dropForeign(['marka_id']);
            $table->dropForeign(['model_id']);
            $table->dropColumn(['marka_id', 'model_id']);
            $table->string('marka')->nullable()->after('id');
            $table->string('model')->nullable()->after('marka');
        });
    }
};
