<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableAddUserRoleAndProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_role_id')->nullable();
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->foreign('user_role_id')->references('id')->on('user_roles');
            $table->foreign('profile_id')->references('id')->on('profiles');
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
            $table->dropForeign(['user_role_id']);
            $table->dropForeign(['profile_id']);
            $table->dropColumn('user_role_id');
            $table->dropColumn('profile_id');
        });
    }
}
