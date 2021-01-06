<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_products_id')->nullable()->comment('Relation with store_products');
            $table->unsignedBigInteger('store_id')->nullable()->comment('Relation with stores');
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('title',255)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('sku',50)->nullable();
            $table->integer('position')->nullable();
            $table->decimal('compare_at_price', 10, 2)->nullable();
            $table->string('fulfillment_service',50)->nullable();
            $table->string('inventory_management',50)->nullable();
            $table->integer('inventory_quantity')->nullable();
            $table->string('option1',255)->nullable();
            $table->string('option2',255)->nullable();
            $table->string('option3',255)->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
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
        Schema::dropIfExists('store_product_variants');
    }
}
