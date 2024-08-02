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
        Schema::create('platforms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('input')->default('username');
            $table->string('baseURL')->nullable();
            $table->boolean('pro')->default(0);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->boolean('status')->default(1);
            $table->string('placeholder_en')->nullable();
            $table->string('placeholder_sv')->nullable();
            $table->string('description_en')->nullable();
            $table->string('description_sv')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('platforms');
    }
};
