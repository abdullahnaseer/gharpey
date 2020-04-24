<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id')->index()->nullable();
            $table->text('question_title');
            $table->text('question_description');

            $table->unsignedBigInteger('item_id'); // service or product
            $table->string('item_type');

            $table->timestamps();

            $table->foreign('buyer_id')->references('id')->on('buyers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
