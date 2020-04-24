<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedInteger('depth')->default(0);
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('featured_image')->nullable();
            $table->timestamps();
        });

        Schema::table('service_categories', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('service_categories')->onDelete('cascade');
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('featured_image')->nullable();
            $table->mediumText('description')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('service_categories')->onDelete('set null');
        });

        Schema::create('service_seller', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->index();
            $table->unsignedBigInteger('seller_id')->index();
            $table->unsignedDecimal('price', 16, 4);
            $table->mediumText('description')->nullable();
            $table->string('featured_image')->nullable();
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
        });

        Schema::create('service_seller_location', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_seller_id')->index();
            $table->unsignedBigInteger('location_id')->index();
            $table->string('location_type');

            $table->foreign('service_seller_id')->references('id')->on('service_seller')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_seller_location');
        Schema::dropIfExists('service_seller');
        Schema::dropIfExists('services');
        Schema::dropIfExists('service_categories');
    }
}
