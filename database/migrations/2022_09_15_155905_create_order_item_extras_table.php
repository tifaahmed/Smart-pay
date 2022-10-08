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
            $table->id();

            $table->integer('order_item_id')->unsigned(); 
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('cascade');

            $table->integer('extra_id')->nullable()->unsigned();
            $table->string('extra_name')->nullable();

            $table->float('price')->default(0);

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
