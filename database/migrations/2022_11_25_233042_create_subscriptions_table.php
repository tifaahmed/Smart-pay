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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table->integer('store_id')->unsigned()->comment('on Delete cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            
            $table->date('start_date');
            $table->date('end_date');

            $table->integer('month_number')->comment('number of months');

            $table->enum('subscription_status', ['pending', 'accepted','canceled','rejected'])->default('pending')
            ->comment('1-start with pending 2-user can canceled 3- admin  rejected or accepted ');
            
            $table->enum('payment_type', [ 'visa','cash'])->default('cash');

            $table->enum('payment_card_status', [ 'paid','pindding', 'rejected' ,'canceled'])->nullable();
            $table->text('payment_card_data')->nullable();

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
        Schema::dropIfExists('subscriptions');
    }
};
