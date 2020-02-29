<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('buyer_id')->index()->nullable();

            $table->string('shipping_phone')->nullable();
            $table->string('shipping_address')->nullable();
            $table->unsignedBigInteger('shipping_location_id')->index()->nullable();

            $table->string('receipt_email')->nullable();

            $table->string('charge_id')->nullable(); // stripe transaction id or other
            $table->mediumText('note')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->foreign('buyer_id')->references('id')->on('buyers')->onDelete('set null');
            $table->foreign('shipping_location_id')->references('id')->on('city_areas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
