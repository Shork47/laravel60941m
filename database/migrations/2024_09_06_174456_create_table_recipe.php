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
        Schema::create('recipe', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dish');
            $table->unsignedBigInteger('id_ingredient');
            $table->foreign('id_dish')->references('id')->on('dish');
            $table->foreign('id_ingredient')->references('id')->on('ingredient');
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe');
    }
};
