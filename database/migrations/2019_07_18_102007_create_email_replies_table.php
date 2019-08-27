<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_replies', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('message_id')->nullable();
            $table->string('department_id')->nullable();
            $table->string('subject')->nullable();
            $table->string('text_body')->nullable();
            $table->string('html_body')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->longText('attachments')->nullable();
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
        Schema::dropIfExists('email_replies');
    }
}
