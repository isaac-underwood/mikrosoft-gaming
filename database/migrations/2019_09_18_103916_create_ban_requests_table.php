<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ban_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ban_user_id')->unsigned(); //the ID of the person requested to be banned
            $table->bigInteger('requested_by_user_id')->unsigned(); // the ID of user who requested the ban
            $table->string('reason');
            $table->timestamps();

            $table->foreign('ban_user_id')->references('id')->on('users');
            $table->foreign('requested_by_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ban_requests');
    }
}
