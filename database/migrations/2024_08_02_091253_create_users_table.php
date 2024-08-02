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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('username', 30)->charset('latin1')->collation('latin1_general_cs')->index()->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('job_title', 255)->nullable();
            $table->string('company', 255)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('cover_photo', 255)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_suspended')->default(0);
            $table->tinyInteger('user_direct')->default(0);
            $table->string('password', 255)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('work_position', 255)->nullable();
            $table->tinyInteger('gender')->nullable()->default(1)->comment('1=male,2=female,3=non-binary,4=not share');
            $table->integer('tiks')->default(0);
            $table->string('dob', 30)->nullable();
            $table->tinyInteger('private')->default(1);
            $table->tinyInteger('verified')->default(0);
            $table->tinyInteger('featured')->default(0);
            $table->string('bio', 255)->nullable();
            $table->string('fcm_token', 255)->nullable();
            $table->timestamp('deactivated_at')->nullable();
            $table->tinyInteger('is_email_sent')->default(0);
            $table->timestamp('created_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
