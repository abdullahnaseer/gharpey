<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportTicketMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_ticket_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('support_ticket_id');
            $table->mediumText('message')->nullable();
            $table->timestamps();

            $table->foreign('support_ticket_id')->references('id')->on('support_tickets')->onDelete('cascade');
        });

        Schema::create('support_ticket_message_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('support_ticket_message_id');
            $table->string('path')->nullable();
            $table->timestamps();

            $table->foreign('support_ticket_message_id')->references('id')->on('support_ticket_messages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_ticket_message_files');
        Schema::dropIfExists('support_ticket_messages');
    }
}
