<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('nutritions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('calories')->nullable();
            $table->decimal('fat', 5, 2)->nullable();
            $table->decimal('carbohydrates', 5, 2)->nullable();
            $table->decimal('protein', 5, 2)->nullable();
            $table->decimal('sugar', 5, 2)->nullable();
            $table->decimal('fiber', 5, 2)->nullable();
            $table->decimal('sodium', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nutritions');
    }
};

