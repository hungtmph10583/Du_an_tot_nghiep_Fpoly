<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('user_id'); // users 
            $table->integer('category_id'); // Categories
            $table->string('slug');
            $table->string('image');
            $table->string('weight');
            $table->integer('breed_id'); // Breeds
            $table->integer('age_id'); // ages
            $table->integer('coupon_id')->nullable(); // Coupons
            $table->integer('gender_id'); // Genders ( Giới tính )
            $table->double('rating')->default(0); // Xep hang
            $table->integer('price')->default(0);
            $table->integer('status')->default(1);
            $table->integer('quantity')->default(0);
            $table->text('description');
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
        Schema::dropIfExists('products');
    }
}
