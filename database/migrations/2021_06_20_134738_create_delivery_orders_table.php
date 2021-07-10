<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipment_order_id');
            $table->unsignedBigInteger('transporter_id');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->string('no_order')->nullable();
            $table->date('date')->nullable();
            $table->date('date_eta')->nullable();
            $table->date('date_pickuo')->nullable();
            $table->date('date_arrive')->nullable();
            $table->unsignedBigInteger('pickup_location_id')->nullable();
            $table->unsignedBigInteger('deliver_location_id')->nullable();
            $table->string('status')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('shipment_order_id')->references('id')->on('shipment_orders');
            $table->foreign('transporter_id')->references('id')->on('profiles');
            $table->foreign('pickup_location_id')->references('id')->on('locations');
            $table->foreign('deliver_location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_orders');
    }
}
