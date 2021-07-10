<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerLocationsTableAddCity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_locations', function (Blueprint $table) {
            $table->string('city')->nullable();
            $table->string('province')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_locations', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->dropColumn('province');
        });
    }
}
