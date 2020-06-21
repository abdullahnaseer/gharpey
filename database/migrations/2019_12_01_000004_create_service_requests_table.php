<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_seller_id')->index()->nullable();
            $table->unsignedBigInteger('service_id')->index()->nullable();
            $table->unsignedBigInteger('seller_id')->index()->nullable();
            $table->unsignedBigInteger('buyer_id')->index()->nullable();
            $table->unsignedBigInteger('location_id')->index()->nullable();
            $table->string('location_type')->default("App\\\Models\\\City");

            $table->enum('status', \App\Models\ServiceRequest::STATUSES)
                ->default(\App\Models\ServiceRequest::STATUS_NEW);

            $table->integer('total_amount')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->string('shipping_address')->nullable();
            $table->unsignedBigInteger('shipping_location_id')->index()->nullable();

            $table->string('receipt_email')->nullable();
            $table->string('charge_id')->nullable(); // stripe transaction id or other
            $table->mediumText('note')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('disputed_at')->nullable();

            $table->timestamps();

            $table->foreign('service_seller_id')->references('id')->on('service_seller')->onDelete('set null');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('set null');
            $table->foreign('buyer_id')->references('id')->on('buyers')->onDelete('set null');
            $table->foreign('location_id')->references('id')->on('cities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropForeign(['service_seller_id']);
            $table->dropForeign(['buyer_id']);
            $table->dropForeign(['location_id']);
        });

        Schema::dropIfExists('service_requests');
    }
}
