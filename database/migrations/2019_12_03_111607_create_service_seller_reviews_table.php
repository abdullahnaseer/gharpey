<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceSellerReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_seller_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_seller_id')->index();
            $table->unsignedBigInteger('service_request_id')->index();
            $table->unsignedBigInteger('buyer_id')->index();
            $table->text('review');
            $table->unsignedSmallInteger('rating')->default(0);
            $table->timestamps();

            $table->foreign('service_seller_id')->references('id')->on('service_seller')->onDelete('cascade');
            $table->foreign('service_request_id')->references('id')->on('service_requests')->onDelete('cascade');
            $table->foreign('buyer_id')->references('id')->on('buyers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_seller_reviews');
    }
}