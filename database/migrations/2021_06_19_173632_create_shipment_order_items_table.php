<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipment_order_id');
            $table->string('name');
            $table->integer('qty');
            $table->string('unit')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('shipment_order_id')->references('id')->on('shipment_orders')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipment_order_items');
    }
}
