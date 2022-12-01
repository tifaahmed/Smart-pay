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

            $table->integer('order_id')->unsigned()->comment('will be deleted if order deleted');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->enum('order_status', [ 
                'not_confirmed','confirmed',
                'shipping','delevered',
                'canceled','rejected',
                'ask_to_retrieve','accept_to_retrieve'
            ])->default('not_confirmed')
            ->comment('1-start with not_confirmed 2-user can canceled 3- store  can confirmed first then rejected or shipping and delevered 4-user can ask_to_retrieve');


            $table->integer('store_id')->unsigned()->comment('will not delete if store deleted');
            $table->string('store_title')->nullable();
            $table->text('store_note')->nullable();
            
            $table->string('coupon_title')->nullable();
            $table->string('coupon_code')->nullable();
            $table->enum('coupon_discount_type', [ 'fixed','percent'])->default('fixed');
            $table->float('coupon_discount')->default(0)->comment(' order_item_sub_totals - discount ');
            

            //1- user paied with card and shop reject
            //2- user paied with cash or card and ask to ask_to_retrieve from the store_id
            //create cuopon automatic to the user_id with store_id
            $table->float('retrieve_price')->default(0)->comment('retrieve mony from single store as coupon');
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
