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
        Schema::table('products', function (Blueprint $table) {
            $table->string('top_notes')->nullable()->after('description');
            $table->string('middle_notes')->nullable()->after('top_notes');
            $table->string('base_notes')->nullable()->after('middle_notes');
            $table->tinyInteger('longevity')->nullable()->after('base_notes'); // 1-5
            $table->tinyInteger('sillage')->nullable()->after('longevity');    // 1-5
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['top_notes', 'middle_notes', 'base_notes', 'longevity', 'sillage']);
        });
    }
};
