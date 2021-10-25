<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()    // Đã hoàn thiện
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); // xg
            $table->integer('discount_type_id'); // xg ( kieu giam gia )
            $table->integer('quantity'); //xg
            $table->string('code'); // xg
            $table->string('details'); // xg
            $table->string('discount'); // chiet khau 
            $table->integer('start_date'); // xg
            $table->integer('end_date'); // xg
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
        Schema::dropIfExists('coupons');
    }
}
