<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('container_no');
            $table->string('shipping_line');
            $table->string('depot');
            $table->string('in_date');
            $table->string('consignee_party');
            $table->string('place');
            $table->string('vessel');
            $table->string('transpoter');
            $table->string('vehicle');
            $table->string('booking_remark');
            $table->string('port_from');
            $table->string('cha');
            $table->string('driver_name');
            $table->string('driver_contact');
            $table->string('size');
            $table->string('type');
            $table->string('status');
            $table->string('sub_status');
            $table->string('max_gross');
            $table->string('tare');
            $table->string('mfg_date');
            $table->string('csc_date');
            $table->string('import_do');
            $table->string('container_remark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
