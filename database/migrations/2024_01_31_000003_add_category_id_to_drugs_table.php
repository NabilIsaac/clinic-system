<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained();
            $table->string('sku')->unique()->after('name'); // Stock Keeping Unit
            $table->integer('reorder_level')->default(10)->after('stock_quantity'); // Minimum quantity before reorder alert
        });
    }

    public function down(): void
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'sku', 'reorder_level']);
        });
    }
};
