<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->string('phone')->nullable();
            $table->string('verification_code')->nullable();
            $table->timestamp('phone_verified_at')->nullable();

            $table->string('cnic')->nullable();

            $table->string('warehouse_address')->nullable();
            $table->unsignedBigInteger('warehouse_location_id')->nullable();

            $table->string('business_address')->nullable();
            $table->unsignedBigInteger('business_location_id')->nullable();

            $table->string('return_address')->nullable();
            $table->unsignedBigInteger('return_location_id')->nullable();

            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('warehouse_location_id')->references('id')->on('city_areas')->onDelete('set null');
            $table->foreign('business_location_id')->references('id')->on('city_areas')->onDelete('set null');
            $table->foreign('return_location_id')->references('id')->on('city_areas')->onDelete('set null');
        });

        Schema::create('seller_password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_password_resets');
        Schema::dropIfExists('sellers');
    }
}
