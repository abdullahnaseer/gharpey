<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRequestQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_request_quotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id')->index();
            $table->decimal('quote');
            $table->enum('type', ['flat', 'hourly'])->default('flat');
            $table->mediumText('note')->nullable();
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('service_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_request_quotes', function (Blueprint $table) {
            $table->dropForeign(['request_id']);
        });
        Schema::dropIfExists('service_request_quotes');
    }
}
