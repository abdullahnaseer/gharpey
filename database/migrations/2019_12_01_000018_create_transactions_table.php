<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->string('user_type')->nullable();

            $table->unsignedBigInteger('reference_id')->index()->nullable();
            $table->string('reference_type')->nullable();

            $table->enum('type', ['debit', 'credit'])->default('credit');
            $table->decimal('amount', 8, 2)->default(0.0);
            $table->decimal('balance', 8, 2)->default(0.0);
            $table->text("note")->nullable();
            $table->timestamps();

//            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
