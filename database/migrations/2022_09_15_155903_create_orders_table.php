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
            $table->integer('user_id')->unsigned()->comment('will not delete if user deleted');

            $table->enum('payment_type', [ 'visa','cash'])->default('cash');

            $table->enum('payment_card_status', [ 'paid','pindding'])->nullable();
            $table->text('payment_card_data')->nullable(); 

            $table->string('order_code')->unique();
            $table->text('order_note')->nullable()->comment('wrote only from admin if needed');

            
            $table->float('order_store_retrieve_sub_totals')->default(0)->comment('collect retrieve_price of table order_stores');
            $table->float('order_store_price_sub_totals')->default(0)->comment('collect sub_total of table order_stores');

            $table->float('site_fee')->default(0);
            $table->float('total')->default(0)->comment('order_store_price_sub_totals + site_fee');

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
