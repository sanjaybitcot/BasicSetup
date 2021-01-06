<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_product_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_products_id')->nullable()->comment('Relation with store_products table');
            $table->unsignedBigInteger('store_id')->nullable()->comment('Relation with stores table');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('position')->nullable();
            $table->text('alt',255)->nullable();
            $table->text('src')->nullable();
            $table->foreign('store_products_id')->references('id')->on('store_products')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
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
        Schema::dropIfExists('store_product_images');
    }
}
