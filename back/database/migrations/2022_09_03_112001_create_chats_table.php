<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->dateTime("fecha");
            $table->string("message");
            $table->unsignedBigInteger("userEnviado_id");
            $table->foreign("userEnviado_id")->references("id")->on("users");
            $table->unsignedBigInteger("userRecibido_id");
            $table->foreign("userRecibido_id")->references("id")->on("users");
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
        Schema::dropIfExists('chats');
    }
};
