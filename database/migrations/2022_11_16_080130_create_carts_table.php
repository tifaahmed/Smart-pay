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
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');


            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->integer('product_id')->unsigned()->comment('will not delete if product deleted');
            $table->integer('store_id')->unsigned()->comment('will not delete if store deleted');
            
            $table->string('product_title')->nullable();
            $table->float('product_discount')->default(0)->comment('10%,5%,15%,20% product offer');
            $table->float('product_price')->default(1)->comment('single product pure price');

            $table->integer('quantity')->default(1); 
            
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
        Schema::dropIfExists('carts');
    }
};
