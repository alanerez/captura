<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebhooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhooks', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('form_id')->nullable();
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->string('format')->nullable();
            $table->string('method')->nullable();
            $table->longText('headers')->nullable();
            $table->longText('body')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webhooks');
    }
}
