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
        Schema::create('stripeorders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('company')->nullable();
            $table->string('address');
            $table->integer('zip')->nullable();
            $table->integer('phone');
            $table->integer('country_id');
            $table->integer('city_id');
            $table->string('notes')->nullable();
            $table->integer('sub_total');
            $table->integer('discount')->nullable();
            $table->integer('charge')->nullable();
            $table->integer('total');
            $table->integer('payment_method');
            $table->integer('customer_id');
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
        Schema::dropIfExists('stripeorders');
    }
};