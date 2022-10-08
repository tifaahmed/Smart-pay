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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->enum('order_status', [ 'not_confirmed','confirmed','shipping','delevered','canceled','ask_to_retrieve'])->default('not_confirmed');
            $table->enum('payment_card_status', [ 'paid','pindding'])->default('pindding');
            $table->enum('payment_type', [ 'visa','cash'])->default('cash');

            $table->integer('user_id')->unsigned(); // customer
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('coupon_id')->nullable()->unsigned();

            $table->integer('address_id')->unsigned();

            $table->float('discount')->default(0); //[note: "50 pound"] 
            $table->float('delevery_fee')->default(0); // [note: 'delevery price'] 
            $table->float('subtotal')->default(0); // [note: "sum products prices [before] "]
            $table->float('total')->default(0); // [note: "after discount "]

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
        Schema::dropIfExists('orders');
    }
};
