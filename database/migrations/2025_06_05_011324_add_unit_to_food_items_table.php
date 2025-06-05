<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('food_items', function (Blueprint $table) {
            $table->string('unit')->after('name');
        });
    }

    public function down()
    {
        Schema::table('food_items', function (Blueprint $table) {
            $table->dropColumn('unit');
        });
    }
};
