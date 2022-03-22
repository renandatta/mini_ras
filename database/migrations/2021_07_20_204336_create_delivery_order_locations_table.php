<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryOrderLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_order_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_order_id');
            $table->unsignedBigInteger('pickup_location_id');
            $table->string('pickup_detail');
            $table->unsignedBigInteger('deliver_location_id');
            $table->string('deliver_detail');
            $table->date('pickup_date');
            $table->time('pickup_time');
            $table->date('loading_date')->nullable();
            $table->time('loading_time')->nullable();
            $table->date('arrive_date')->nullable();
            $table->time('arrive_time')->nullable();
            $table->date('unloading_date')->nullable();
            $table->time('unloading_time')->nullable();
            $table->string('file')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->foreign('delivery_order_id')->references('id')->on('delivery_orders')
                ->onDelete('cascade');
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
        Schema::dropIfExists('delivery_order_locations');
    }
}
