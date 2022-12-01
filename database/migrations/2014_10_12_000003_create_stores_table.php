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
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->enum('status', ['pending', 'accepted', 'rejected' ,'canceled' , 'busy'])->default('pending');

            $table->string('image')->nullable(); // [note: "store logo  pizza"]

            $table->text('title')->nullable(); // [note: "translatable"]
            $table->text('description')->nullable(); // [note: "translatable"]
            $table->string('phone')->nullable(); 

            $table->float('rate')->default(5);
            $table->float('delevery_fee')->default(0);
            

            $table->text('address')->nullable(); // [note: "translatable"]
            $table->string('streat')->nullable(); // [note: "translatable"]
            $table->string('building')->nullable(); // [note: "translatable"]

            $table->integer('city_id')->nullable()->comment('will not delete if city deleted');  
            $table->string('city_name')->nullable();  

            $table->string('latitude')->nullable() ;
            $table->string('longitude')->nullable();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
