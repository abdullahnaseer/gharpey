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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('featured_image')->nullable();
            $table->timestamps();
        });

        Schema::create('product_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('featured_image')->nullable();
            $table->text('description')->nullable();
            $table->unsignedDecimal('price', 16, 2);

//            $table->unsignedBigInteger('approved_by_id')->nullable();
//            $table->string('approved_by_type')->nullable();
//            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
        });

        Schema::create('product_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('tag_id')->index();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('product_tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_tag');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_tags');
        Schema::dropIfExists('product_categories');
    }
}
