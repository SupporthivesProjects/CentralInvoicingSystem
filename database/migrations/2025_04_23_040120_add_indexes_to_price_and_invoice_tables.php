<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product_price_histories', function (Blueprint $table) {
            $table->index('last_price_changed', 'idx_last_price_changed');
        });

        Schema::table('invoice_generation_histories', function (Blueprint $table) {
            $table->index('created_at', 'idx_created_at');
        });
    }

    public function down(): void
    {
        Schema::table('product_price_histories', function (Blueprint $table) {
            $table->dropIndex('idx_last_price_changed');
        });

        Schema::table('invoice_generation_histories', function (Blueprint $table) {
            $table->dropIndex('idx_created_at');
        });
    }
};
