<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('progress_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('progress_entry_id');
            $table->string('image_path');
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('progress_entry_id')->references('id')->on('progress_entries')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('progress_images');
    }
};
