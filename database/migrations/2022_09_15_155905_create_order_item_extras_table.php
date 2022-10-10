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
        Schema::create('order_item_extras', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('order_item_id')->unsigned(); 
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('cascade');

            $table->string('extra_name');

            $table->float('sub_total')->default(0)->comment('one extra price * product quantity');

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
        Schema::dropIfExists('order_item_extras');
    }
};
