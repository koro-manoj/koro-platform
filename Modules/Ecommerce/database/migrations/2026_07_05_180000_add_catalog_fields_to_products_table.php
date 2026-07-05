<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('description');
            $table->string('category', 50)->nullable()->after('image_url');
            $table->string('badge', 50)->nullable()->after('category');
            $table->unsignedBigInteger('compare_at_price_cents')->nullable()->after('price_cents');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['image_url', 'category', 'badge', 'compare_at_price_cents']);
        });
    }
};
