<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDeliveryOrderAddTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_orders', function (Blueprint $table) {
            $table->time('time_pickup')->nullable();
            $table->date('date_loading')->nullable();
            $table->time('time_loading')->nullable();
            $table->time('time_arrive')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_orders', function (Blueprint $table) {
            $table->dropColumn('time_pickup');
            $table->dropColumn('date_loading');
            $table->dropColumn('time_loading');
            $table->dropColumn('time_arrive');
        });
    }
}
