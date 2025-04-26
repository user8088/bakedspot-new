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
        Schema::table('order_items', function (Blueprint $table) {
            // Allow null for product_id as we'll be using item_1, item_2, etc. for packs
            $table->foreignId('product_id')->nullable()->change();

            // Adding fields for pack items
            $table->string('pack_type')->nullable()->after('product_id');
            $table->string('item_1')->nullable()->after('pack_type');
            $table->string('item_2')->nullable()->after('item_1');
            $table->string('item_3')->nullable()->after('item_2');
            $table->string('item_4')->nullable()->after('item_3');
            $table->string('item_5')->nullable()->after('item_4');
            $table->string('item_6')->nullable()->after('item_5');
            $table->string('item_7')->nullable()->after('item_6');
            $table->string('item_8')->nullable()->after('item_7');

            // Adding price for individual item
            $table->decimal('price', 10, 2)->default(0)->after('item_8');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn([
                'pack_type', 'item_1', 'item_2', 'item_3', 'item_4',
                'item_5', 'item_6', 'item_7', 'item_8', 'price'
            ]);
            $table->foreignId('product_id')->nullable(false)->change();
        });
    }
};
