<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVehiclesTableAddInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('no_license')->nullable();
            $table->date('data_license_expired')->nullable();
            $table->string('no_registration')->nullable();
            $table->date('date_tax_expired')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('no_license');
            $table->dropColumn('date_license_expired');
            $table->dropColumn('no_registration');
            $table->dropColumn('date_tax_expired');
        });
    }
}
