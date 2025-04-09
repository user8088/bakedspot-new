<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sectors', function (Blueprint $table) {
            $table->double('delivery_charges')->nullable()->after('sector_name');
        });
    }

    public function down()
    {
        Schema::table('sectors', function (Blueprint $table) {
            $table->dropColumn('delivery_charges');
        });
    }
};
