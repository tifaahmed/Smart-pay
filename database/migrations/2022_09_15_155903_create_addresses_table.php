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
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->string('city_id')->nullable()->comment('will not delete if city deleted');  
            $table->string('city_name')->nullable();  

            $table->text('address'); 
            $table->string('department')->nullable();  
            $table->string('house')->nullable();  
            $table->string('street')->nullable();  
            $table->text('note')->nullable(); 
            $table->enum('type', ['home', 'work', 'rest' ,'mosque'])->default('home');

            $table->integer('floor')->nullable();   
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
        Schema::dropIfExists('addresses');
    }
};
