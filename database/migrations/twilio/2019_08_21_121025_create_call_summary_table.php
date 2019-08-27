<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_summary', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone_number');
            $table->string('formatted_phone_number');
            $table->string('outbound_dial');
            $table->string('inbound');
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
        Schema::dropIfExists('call_summary');
    }
}
