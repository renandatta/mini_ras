<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDeliveryOrdersTableAddNote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_orders', function (Blueprint $table) {
            $table->text('note_loading')->nullable();
            $table->text('note_arrive')->nullable();
            $table->text('note_unloading')->nullable();
            $table->date('date_unloading')->nullable();
            $table->time('time_unloading')->nullable();
            $table->string('finish_attachment')->nullable();
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
            $table->dropColumn('note_loading');
            $table->dropColumn('note_arrive');
            $table->dropColumn('note_unloading');
            $table->dropColumn('date_unloading');
            $table->dropColumn('time_unloading');
            $table->dropColumn('finish_attachment');
        });
    }
}
