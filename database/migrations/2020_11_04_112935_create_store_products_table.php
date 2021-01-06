<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->nullable()->comment('Relation with stores table');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('title',255)->nullable();
            $table->string('vendor',255)->nullable();
            $table->string('product_type',255)->nullable();
            $table->string('handle',255)->nullable();
            $table->text('tags')->nullable();
            $table->string('published_scope',50)->nullable();
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
        Schema::dropIfExists('store_products');
    }
}
