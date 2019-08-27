<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('leads', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('lead_source_id')->nullable();
            $table->string('gravity_form_title')->nullable();
            $table->string('gravity_form_id')->nullable();
            $table->longText('data')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('leads');
    }
}
