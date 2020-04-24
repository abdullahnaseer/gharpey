<?php

use App\Helpers\ServiceQuestionAuthRule;
use App\Helpers\ServiceQuestionType\ServiceQuestionType;
use App\Helpers\ServiceQuestionValidationRule\ServiceQuestionValidationRule;
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
            $table->id();
            $table->foreignId('service_id')->nullable()->references('id')->on('services')->onDelete('cascade');
            $table->foreignId('service_seller_id')->nullable()->references('id')->on('service_seller')->onDelete('cascade');
            $table->unsignedInteger('order_priority')->default(0);
            $table->string('name')->nullable();
            $table->text('question')->nullable();
            $table->text('placeholder')->nullable();
            $table->enum('type', ServiceQuestionType::getAllTypesWithStringSafe())->default(str_replace("\\", "\\\\\\", ServiceQuestionType::TEXT));
            $table->enum('auth_rule', ServiceQuestionAuthRule::getAllTypesWithStringSafe())->nullable();

            $table->boolean('has_price_change')->default(false);

            $table->timestamps();
        });

        Schema::create('service_question_validation_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->references('id')->on('service_questions')->onDelete('cascade');
            $table->enum('type', ServiceQuestionValidationRule::getAllTypesWithStringSafe())->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
        });

        Schema::create('service_question_choices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->references('id')->on('service_questions')->onDelete('cascade');
            $table->unsignedInteger('order_priority')->default(0);
            $table->string('choice');

            $table->integer('price_change')->nullable();

            $table->timestamps();
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
        Schema::dropIfExists('service_question_validation_rules');
        Schema::dropIfExists('service_questions');
    }
}
