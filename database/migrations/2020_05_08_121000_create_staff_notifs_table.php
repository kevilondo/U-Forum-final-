<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffNotifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_notifs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staff_id');
            $table->integer('recipient');
            $table->integer('message_id');
            $table->string('notification');
            $table->string('recipient_role');
            $table->integer('seen');
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
        Schema::dropIfExists('staff_notifs');
    }
}
