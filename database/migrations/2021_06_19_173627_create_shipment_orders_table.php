<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consignee_id');
            $table->unsignedBigInteger('shipper_id');
            $table->string('no_order');
            $table->date('date');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('consignee_id')->references('id')->on('profiles');
            $table->foreign('shipper_id')->references('id')->on('profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipment_orders');
    }
}
