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
        Schema::create('order_stores', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('store_id')->unsigned()->comment('will not delete if store deleted');
            $table->integer('order_id')->unsigned();
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->string('store_title')->nullable();

            $table->string('coupon_title')->nullable();
            $table->string('coupon_code')->nullable();
            $table->enum('coupon_discount_type', [ 'fixed','percent'])->default('fixed');

            $table->float('coupon_discount')->default(0)->comment(' order_item_sub_totals - discount ');
            $table->float('delevery_fee')->default(0)->comment('delevery fee from single stores');
            $table->float('order_item_sub_totals')->default(0)->comment('collect sub_total of table order_items');
            $table->float('sub_total')->default(0)->comment(' (order_item_sub_totals + delevery_fee ) - coupon_discount ');
           
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
        Schema::dropIfExists('order_stores');
    }
};
