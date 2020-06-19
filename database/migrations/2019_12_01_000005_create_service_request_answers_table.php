<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\ServiceQuestionType\ServiceQuestionType;

class CreateServiceRequestAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_request_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id')->index();
            $table->unsignedBigInteger('question_id')->index()->nullable();
            $table->unsignedBigInteger('answer_id')->index();
            $table->string('answer_type');

            $table->string('name')->nullable();
            $table->text('question')->nullable();
            $table->enum('type', ServiceQuestionType::getAllTypesWithStringSafe())->default(str_replace("\\", "\\\\\\", ServiceQuestionType::TEXT));

            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('service_requests')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('service_questions')->onDelete('set null');
        });

        Schema::create('service_request_answer_texts', function (Blueprint $table) {
            $table->id();
            $table->string('answer');
        });

        Schema::create('service_request_answer_booleans', function (Blueprint $table) {
            $table->id();
            $table->boolean('answer');
        });

        Schema::create('service_request_answer_choices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('choice_id')->index()->nullable();

            $table->string('choice')->nullable();
            $table->integer('price_change')->nullable();

            $table->foreign('choice_id')->references('id')->on('service_question_choices')->onDelete('set null');
        });

        Schema::create('service_request_answer_text_multilines', function (Blueprint $table) {
            $table->id();
            $table->text('answer');
        });

        Schema::create('service_request_answer_dates', function (Blueprint $table) {
            $table->id();
            $table->date('answer');
        });

        Schema::create('service_request_answer_times', function (Blueprint $table) {
            $table->id();
            $table->time('answer');
        });

        Schema::create('service_request_answer_date_times', function (Blueprint $table) {
            $table->id();
            $table->dateTime('answer');
        });

        Schema::create('service_request_answer_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_path');
            $table->string('file_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_request_answer_files');
        Schema::dropIfExists('service_request_answer_date_times');
        Schema::dropIfExists('service_request_answer_times');
        Schema::dropIfExists('service_request_answer_dates');
        Schema::dropIfExists('service_request_answer_text_multilines');
        Schema::dropIfExists('service_request_answer_choices');
        Schema::dropIfExists('service_request_answer_booleans');
        Schema::dropIfExists('service_request_answer_texts');
        Schema::dropIfExists('service_request_answers');
    }
}
