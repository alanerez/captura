<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('accountSid');
            $table->string('annotation')->nullable();
            $table->string('answeredBy')->nullable();
            $table->string('apiVersion');
            $table->string('callerName')->nullable();
            $table->string('dateCreated');
            $table->string('dateUpdated');
            $table->string('direction');
            $table->string('duration');
            $table->string('endTime');
            $table->string('forwardedFrom')->nullable();
            $table->string('from');
            $table->string('fromFormatted');
            $table->string('groupSid')->nullable();
            $table->string('parentCallSid')->nullable();
            $table->string('phoneNumberSid')->nullable();
            $table->string('price');
            $table->string('priceUnit');
            $table->string('sid');
            $table->string('startTime');
            $table->string('status');
            $table->string('to');
            $table->string('toFormatted');
            $table->string('uri');
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
        Schema::dropIfExists('call_records');
    }
}
