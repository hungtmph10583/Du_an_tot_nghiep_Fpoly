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
            $table->integer('category_id'); // Bang chinh
            $table->integer('breed_id'); // Bang chinh ( Giong loai )
            $table->string('slug');
            $table->string('image');
            $table->string('weight');
            $table->integer('age_id'); // Bang chinh ( Tuoi )
            $table->integer('color_id')->nullable();
            $table->integer('gender_id'); // Bang chinh ( Giới tính )
            $table->integer('creator'); // Bang chính ( users )
            $table->integer('price')->default(0);
            $table->integer('status')->default(1);
            $table->integer('quantity')->default(0);
            $table->text('detail');
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
