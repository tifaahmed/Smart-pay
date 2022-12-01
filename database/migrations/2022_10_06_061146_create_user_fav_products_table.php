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
        Schema::create('user_fav_products', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned()->comment('onDelete cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->integer('product_id')->unsigned()->comment('onDelete cascade');
            $table->foreign('product_id')->references('id')->on('product_items')->onDelete('cascade');
            
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
        Schema::dropIfExists('user_fav_products');
    }
};
