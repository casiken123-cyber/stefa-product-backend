<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_name')->nullable()->after('total');
            $table->string('shipping_phone', 30)->nullable()->after('shipping_name');
            $table->string('shipping_address')->nullable()->after('shipping_phone');
            $table->string('shipping_city')->nullable()->after('shipping_address');
            $table->string('shipping_zip', 20)->nullable()->after('shipping_city');
            $table->string('payment_method', 50)->nullable()->after('shipping_zip');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_name',
                'shipping_phone',
                'shipping_address',
                'shipping_city',
                'shipping_zip',
                'payment_method',
            ]);
        });
    }
};