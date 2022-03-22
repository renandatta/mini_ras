<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_order_id');
            $table->string('name');
            $table->integer('qty');
            $table->string('unit')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->foreign('delivery_order_id')->references('id')->on('delivery_orders')
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
        Schema::dropIfExists('delivery_order_items');
    }
}
