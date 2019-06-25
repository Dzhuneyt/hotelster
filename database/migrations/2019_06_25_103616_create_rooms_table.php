<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;



class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('hotel_id');
            $table->unsignedBigInteger('room_type_id');
            $table->unsignedBigInteger('room_capacity_id');
            $table->string('room_image_url')
                  ->nullable();

            $table->foreign('room_type_id')
                  ->references('id')
                  ->on('room_types');

            $table->foreign('room_capacity_id')
                  ->references('id')
                  ->on('room_capacities');
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
        Schema::dropIfExists('rooms');
    }
}
