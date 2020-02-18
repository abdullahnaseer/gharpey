<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_id')->index()->nullable();
            $table->unsignedBigInteger('service_seller_id')->index()->nullable();
            $table->unsignedInteger('order_priority')->default(0);
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->text('question')->nullable();
            $table->enum('type', [
                \App\Models\ServiceQuestion::TYPE_BOOLEAN,
                \App\Models\ServiceQuestion::TYPE_TEXT,
                \App\Models\ServiceQuestion::TYPE_TEXT_MULTILINE,
                \App\Models\ServiceQuestion::TYPE_SELECT,
                \App\Models\ServiceQuestion::TYPE_SELECT_MULTIPLE,
                \App\Models\ServiceQuestion::TYPE_DATE,
                \App\Models\ServiceQuestion::TYPE_TIME,
                \App\Models\ServiceQuestion::TYPE_DATE_TIME,
                \App\Models\ServiceQuestion::TYPE_FILE,
                \App\Models\ServiceQuestion::TYPE_FILE_MULTIPLE,
            ])->default(App\Models\ServiceQuestion::TYPE_TEXT);

            $table->boolean('is_locked')->default(false);
            $table->boolean('is_required')->default(false);
            $table->string('auth_rule')->default(\App\Models\ServiceQuestion::AUTH_ANY);

            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('service_seller_id')->references('id')->on('service_seller')->onDelete('cascade');
        });

        Schema::create('service_question_choices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('question_id')->index();
            $table->unsignedInteger('order_priority')->default(0);
            $table->string('choice');
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('service_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_question_choices');
        Schema::dropIfExists('service_questions');
    }
}
