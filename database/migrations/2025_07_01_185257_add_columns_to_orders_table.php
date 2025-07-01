<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->references('id')
                ->on('users')->nullOnDelete();

            $table->string('order_number')->unique();
            $table->decimal('sub_total', 10, 2);

        });

        Schema::table('order_products', function (Blueprint $table) {
            $table->foreignId('color_id')
                ->nullable()
                ->references('id')
                ->on('colors')->nullOnDelete();

            $table->decimal('price', 10, 2);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['order_number', 'sub_total']);
        });

        Schema::table('order_products', function (Blueprint $table) {
            $table->dropForeign(['color_id']);
            $table->dropColumn(['price']);
        });
    }
};
