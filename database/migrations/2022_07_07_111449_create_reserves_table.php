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
        Schema::create('reserves', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('plan');
            $table->string('pattern');
            $table->string('place');
            $table->string('driver');
            $table->string('memo');
            $table->unsignedBigInteger('user_id');
            $table->integer('boat_num');
            $table->integer('status');
            $table->unsignedBigInteger('reserve_list_id');
            $table->unsignedBigInteger('waiting_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('reserve_list_id')->references('id')->on('reserve_lists');
            $table->foreign('waiting_id')->references('id')->on('waitings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserves');
    }
};
