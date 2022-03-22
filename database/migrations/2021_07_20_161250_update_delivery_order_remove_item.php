<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDeliveryOrderRemoveItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_orders', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('qty');
            $table->dropColumn('unit');
            $table->text('description');
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
            $table->string('name')->nullable();
            $table->integer('qty')->nullable();
            $table->string('unit')->nullable();
            $table->dropColumn('description');
        });
    }
}
