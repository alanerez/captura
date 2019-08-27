<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('incoming_host')->nullable();
            $table->string('incoming_port')->nullable();
            $table->string('incoming_encryption')->nullable();
            $table->string('incoming_protocol')->nullable();
            $table->boolean('incoming_validate_cert')->nullable();
            $table->string('outgoing_host')->nullable();
            $table->string('outgoing_port')->nullable();
            $table->string('outgoing_encryption')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
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
        Schema::dropIfExists('departments');
    }
}
