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
        Schema::create('scan_visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visiting_id');
            $table->unsignedBigInteger('visited_id');
            $table->timestamps();

            $table->foreign('visiting_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('visited_id')->references('id')->on('users')->onDelete('cascade');

            $table->index(['visiting_id', 'visited_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scan_visits');
    }
};
