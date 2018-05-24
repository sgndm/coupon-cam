<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('photo');
            $table->string('photo_obj')->nullable();
            $table->string('full_photo')->nullable();
            $table->string('estimated_value')->nullable();
            $table->string('availability');
            $table->text('term_condition')->nullable();
            $table->string('start_at')->nullable();
            $table->string('end_at')->nullable();
            $table->text('store_id')->nullable();
            $table->integer('promo_id')->unsigned();
            $table->foreign('promo_id')->references('id')->on('promos');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('coupons');
    }
}
