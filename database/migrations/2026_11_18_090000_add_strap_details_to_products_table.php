<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Details that describe a watch strap. All are optional, so existing products keep working.
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedTinyInteger('lug_width')->nullable();   // in millimetres (18, 20, 22 ...)
            $table->string('leather_type', 50)->nullable();         // calfskin, full-grain, suede ...
            $table->string('color', 50)->nullable();
            $table->string('buckle', 50)->nullable();               // for example "Brushed steel pin buckle"
            $table->string('length', 20)->nullable();               // Standard or Long
            $table->boolean('quick_release')->default(false);       // quick-release spring bars
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['lug_width', 'leather_type', 'color', 'buckle', 'length', 'quick_release']);
        });
    }
};