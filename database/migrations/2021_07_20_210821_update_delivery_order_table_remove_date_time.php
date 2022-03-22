<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDeliveryOrderTableRemoveDateTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_orders', function (Blueprint $table) {
            $table->dropColumn('date_eta');
            $table->dropColumn('date_pickup');
            $table->dropColumn('date_arrive');
            $table->dropColumn('date_loading');
            $table->dropColumn('date_arrive');
            $table->dropColumn('date_unloading');
            $table->dropColumn('time_pickup');
            $table->dropColumn('time_arrive');
            $table->dropColumn('time_loading');
            $table->dropColumn('time_arrive');
            $table->dropColumn('time_unloading');
            $table->dropColumn('finish_attachment');
            $table->dropColumn('note_loading');
            $table->dropColumn('note_unloading');
            $table->dropColumn('status');
            $table->dropColumn('description');
            $table->dropColumn('vehicle_id');

            $table->dropForeign(['pickup_location_id']);
            $table->dropColumn('pickup_location_id');
            $table->dropForeign(['deliver_location_id']);
            $table->dropColumn('deliver_location_id');
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
            $table->date('date_eta');
            $table->date('date_pickup');
            $table->date('date_arrive');
            $table->date('date_loading');
            $table->date('date_arrive');
            $table->date('date_unloading');
            $table->time('time_pickup');
            $table->time('time_arrive');
            $table->time('time_loading');
            $table->time('time_arrive');
            $table->time('time_unloading');
            $table->string('finish_attachment');
            $table->string('note_loading');
            $table->string('note_unloading');
            $table->string('status');
            $table->string('description');
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('pickup_location_id');
            $table->foreign('pickup_location_id')->references('id')->on('locations');
            $table->unsignedBigInteger('deliver_location_id');
            $table->foreign('deliver_location_id')->references('id')->on('locations');
        });
    }
}
