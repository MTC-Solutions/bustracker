<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("firstName");
            $table->string("lastName");
            $table->integer("age");
            $table->string("hireDate");
            $table->string("email");
            $table->bigInteger('user_id')->unsigned();
            $table->foreign("user_id")->references("id")->on("user")->onDelete("cascade");
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
        Schema::dropIfExists('drivers');
    }
}
