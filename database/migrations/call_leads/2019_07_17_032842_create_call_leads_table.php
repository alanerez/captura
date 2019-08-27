<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('caller_name')->nullable();
            $table->string('caller_number');
            $table->string('call_sid');
            $table->timestamps();
            $table->integer('lead_source_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_leads');
    }
}
