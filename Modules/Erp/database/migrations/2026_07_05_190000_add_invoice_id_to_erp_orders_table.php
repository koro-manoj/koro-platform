<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('erp_orders', function (Blueprint $table) {
            $table->foreignId('invoice_id')->nullable()->after('id')->constrained('invoices')->nullOnDelete();
            $table->unique('invoice_id');
        });
    }

    public function down(): void
    {
        Schema::table('erp_orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('invoice_id');
        });
    }
};
