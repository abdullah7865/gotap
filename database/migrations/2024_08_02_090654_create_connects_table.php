<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('connecting_id');
            $table->unsignedBigInteger('connected_id');
            $table->timestamps();
            $table->foreign('connecting_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('connected_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connects');
    }
};
