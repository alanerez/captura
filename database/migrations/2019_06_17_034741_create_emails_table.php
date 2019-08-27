<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('message_id')->nullable();
            $table->string('message_no')->nullable();

            $table->string('subject')->nullable();
            $table->longText('references')->nullable();
            $table->string('date')->nullable();

            $table->longText('from')->nullable();
            $table->longText('to')->nullable();

            $table->longText('cc')->nullable();
            $table->longText('bcc')->nullable();

            $table->longText('text_body')->nullable();
            $table->longText('html_body')->nullable();

            $table->longText('reply_to')->nullable();
            $table->longText('in_reply_to')->nullable();

            $table->longText('sender')->nullable();

            $table->longText('priority')->nullable();

            $table->string('uid')->nullable();
            $table->string('msglist')->nullable();

            $table->longText('flags')->nullable();

            $table->longText('attachments')->nullable();

            $table->string('department_id')->nullable();
            $table->string('assigned_user_id')->nullable();
            $table->string('reply_user_id')->nullable();
            $table->string('status_id')->nullable();
            $table->string('service_id')->nullable();
            $table->string('priority_id')->nullable();
            $table->longText('tags')->nullable();
            $table->string('type')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('emails');
    }
}
