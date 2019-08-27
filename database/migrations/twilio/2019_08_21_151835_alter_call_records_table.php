<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCallRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('call_records', function (Blueprint $table){
            $table->string('accountSid')->nullable()->change();
            $table->string('apiVersion')->nullable()->change();
            $table->string('dateCreated')->nullable()->change();
            $table->string('dateUpdated')->nullable()->change();
            $table->string('direction')->nullable()->change();
            $table->string('duration')->nullable()->change();
            $table->string('endTime')->nullable()->change();
            $table->string('from')->nullable()->change();
            $table->string('fromFormatted')->nullable()->change();
            $table->string('price')->nullable()->change();
            $table->string('priceUnit')->nullable()->change();
            $table->string('sid')->nullable()->change();
            $table->string('startTime')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->string('to')->nullable()->change();
            $table->string('toFormatted')->nullable()->change();
            $table->string('uri')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('call_records', function (Blueprint $table) {
            $table->string('accountSid')->change;
            $table->string('apiVersion')->change;
            $table->string('dateCreated')->change;
            $table->string('dateUpdated')->change;
            $table->string('direction')->change;
            $table->string('duration')->change;
            $table->string('endTime')->change;
            $table->string('from')->change;
            $table->string('fromFormatted')->change;
            $table->string('price')->change;
            $table->string('priceUnit')->change;
            $table->string('sid')->change;
            $table->string('startTime')->change;
            $table->string('status')->change;
            $table->string('to')->change;
            $table->string('toFormatted')->change;
            $table->string('uri')->change;
        });
    }
}
