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
        Schema::create('user_rate_stores', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->nullable()->unsigned()->comment('onDelete cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->integer('store_id')->nullable()->unsigned()->comment('onDelete cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            
            $table->integer('rate')->default('1');

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
        Schema::dropIfExists('user_rate_stores');
    }
};
