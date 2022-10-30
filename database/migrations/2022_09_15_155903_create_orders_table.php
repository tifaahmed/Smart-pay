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

            $table->enum('order_status', [ 'not_confirmed','confirmed','shipping','delevered','canceled','ask_to_retrieve'])->default('not_confirmed');
            $table->enum('payment_type', [ 'visa','cash'])->default('cash');
            $table->enum('payment_card_status', [ 'paid','pindding'])->nullable();


            $table->float('order_store_sub_totals')->default(0)->comment('collect price of table order_stores');
            $table->float('site_fee')->default(0);
            
            $table->string('order_code')->nullable();
            $table->text('order_note')->nullable();

            $table->float('total')->default(0)->comment('(order_store_sub_totals + site_fee');

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
