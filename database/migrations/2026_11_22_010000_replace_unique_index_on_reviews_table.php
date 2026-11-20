<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // One review per customer per product blocked reviewing a second purchase of the same strap
            $table->dropUnique(['user_id', 'product_id']);

            // One review per purchase (order + product) instead
            $table->unique(['user_id', 'order_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'order_id', 'product_id']);
            $table->unique(['user_id', 'product_id']);
        });
    }
};