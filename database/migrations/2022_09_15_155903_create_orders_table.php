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

            $table->integer('user_id')->unsigned()->comment('will not delete if user deleted');

            $table->string('coupon_title')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('coupon_store_name')->nullable();
            
            $table->float('delevery_fee_sub_total')->default(0)->comment('delevery price from many stores');
            $table->float('product_sub_total')->default(0)->comment('collect price of table order_items');
            $table->float('extras_sub_total')->default(0)->comment('collect price of table order_item_extras');
            $table->float('coupon_discount')->default(0)->comment('discount from single store');
            $table->float('total')->default(0)->comment('(product_sub_total + extras_sub_total + delevery_fee_sub_total) - coupon_discount ');

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
