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
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable()->comment('translatable');
            $table->string('code')-> unique( ) ;
            $table->enum('type', [ 'fixed','percent'])->default('fixed');
            $table->integer('usage_limit')->default(1)->comment(' how many will use it');
            $table->float('percent_limit')->nullable()->comment('work when type is percent'); 

            $table->timestamp('start_date')->useCurrent()->comment('when will start'); 
            $table->timestamp('end_date')->nullable()->comment('if null coupons will never end'); 

            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->integer('store_id')->unsigned();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            

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
        Schema::dropIfExists('coupons');
    }
};
