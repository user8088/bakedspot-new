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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('pack_type');
            $table->unsignedBigInteger('item_1')->nullable();
            $table->unsignedBigInteger('item_2')->nullable();
            $table->unsignedBigInteger('item_3')->nullable();
            $table->unsignedBigInteger('item_4')->nullable();
            $table->unsignedBigInteger('item_5')->nullable();
            $table->unsignedBigInteger('item_6')->nullable();
            $table->unsignedBigInteger('item_7')->nullable();
            $table->unsignedBigInteger('item_8')->nullable();
            $table->decimal('total_price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
