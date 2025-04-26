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
        Schema::table('orders', function (Blueprint $table) {
            // Customer Information
            $table->string('name')->nullable()->after('id');
            $table->string('email')->nullable()->after('name');
            $table->string('phone')->nullable()->after('email');

            // Delivery Address
            $table->string('address')->nullable()->after('phone');
            $table->string('city')->nullable()->after('address');
            $table->string('area')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('area');
            $table->text('delivery_notes')->nullable()->after('postal_code');

            // Payment and Delivery Information
            $table->string('payment_method')->default('cod')->after('delivery_notes');
            $table->foreignId('sector_id')->nullable()->after('payment_method');
            $table->decimal('delivery_charges', 10, 2)->default(0)->after('sector_id');
            $table->decimal('subtotal', 10, 2)->default(0)->after('delivery_charges');
            $table->renameColumn('total_price', 'total');

            // Add session ID for guest checkout
            $table->string('session_id')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'name', 'email', 'phone',
                'address', 'city', 'area', 'postal_code', 'delivery_notes',
                'payment_method', 'sector_id', 'delivery_charges', 'subtotal',
                'session_id'
            ]);
            $table->renameColumn('total', 'total_price');
        });
    }
};
