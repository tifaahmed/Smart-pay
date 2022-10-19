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
        Schema::create('order_informations', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->string('user_full_name');
            $table->string('phone');

            $table->text('address'); 
            $table->string('department')->nullable();  
            $table->string('house')->nullable();  
            $table->string('street')->nullable();  
            $table->text('note')->nullable(); 
            $table->enum('type', ['home', 'work', 'rest' ,'mosque'])->default('home');

            
            $table->string('city_name')->nullable();  

            $table->string('latitude')->nullable();   
            $table->string('longitude')->nullable();   

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
        Schema::dropIfExists('order_informations');
    }
};
