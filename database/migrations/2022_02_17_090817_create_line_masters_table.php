<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_masters', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('code');
            $table->string('client_name');
            $table->text('address');
            $table->string('city');
            $table->integer('pincode');
            $table->string('b_l');
            $table->string('loc_code');
            $table->string('cont_pers');
            $table->string('email');
            $table->bigInteger('phone');
            $table->integer('status');
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
        Schema::dropIfExists('line_masters');
    }
}
