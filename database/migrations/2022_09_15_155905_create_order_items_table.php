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
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('order_store_id')->unsigned();
                $table->foreign('order_store_id')->references('id')->on('order_stores')->onDelete('cascade');

            $table->integer('product_id')->unsigned()->comment('will not delete if product deleted');
            $table->string('product_title')->nullable();
            $table->float('product_offer')->default(0)->comment('10%,5%,15%,20% product offer');
            $table->float('product_price')->default(1)->comment('single product pure price');

            $table->integer('product_quantity')->default(1); 

            $table->float('order_item_extra_sub_totals')->default(0)->comment('collect sub_total of table order_item_extras');


            $table->float('sub_total')->default(0)->comment('(product_price after offer  * quantity ) + order_item_extra_sub_totals');

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
        Schema::dropIfExists('order_items');
    }
};
