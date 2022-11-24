<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('cart_extras', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('cart_id')->unsigned();
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            
            $table->integer('extra_id')->unsigned()->comment('will not delete if extra deleted');
            $table->string('extra_title')->nullable();
            $table->float('extra_price')->default(0);

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('cart_extras');
    }
};
