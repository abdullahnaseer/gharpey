<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_withdraws', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id')->index()->nullable();
            $table->unsignedBigInteger('transaction_id')->index()->nullable();
            $table->unsignedInteger('amount');
            $table->unsignedInteger('fee')->default(0);
            $table->string('bank')->nullable();
            $table->string('name')->nullable();
            $table->string('account_no')->nullable();
            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('set null');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_withdraws');
    }
}
