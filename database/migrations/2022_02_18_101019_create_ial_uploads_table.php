<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIalUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ial_uploads', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('container_no');
            $table->string('import_do');
            $table->string('vessel');
            $table->string('size');
            $table->string('type');
            $table->string('shipper');
            $table->string('voyage');
            $table->string('port');
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
        Schema::dropIfExists('ial_uploads');
    }
}
