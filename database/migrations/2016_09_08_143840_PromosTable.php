<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PromosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->time('start_at');
            $table->string('promo_desc')->nullable();
            $table->string('promo_lenght');
            $table->string('promo_repeat'); // daily on every Monday, Tuesday
            $table->string('promo_repeat_values'); // daily on every Monday, Tuesday
            $table->string('advance_warning');
            $table->string('coupon_code');
            $table->integer('store_id')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('used',[0,1])->default(0);
            $table->enum('active',[0,1])->default(1);
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
        Schema::drop('promos');
    }
}
