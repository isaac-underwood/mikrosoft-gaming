<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserProfileFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('real_name')->after('updated_at')->nullable();
            $table->string('interests')->after('real_name')->nullable();
            $table->boolean('profile_visibility')->default('1')->after('interests');
            $table->string('location')->after('profile_visibility')->nullable();
            $table->string('favourite_games')->after('location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('real_name');
            $table->dropColumn('interests');
            $table->dropColumn('profile_visibility');
            $table->dropColumn('location');
            $table->dropColumn('favourite_games');
        });
    }
}
