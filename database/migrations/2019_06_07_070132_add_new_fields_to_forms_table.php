<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->boolean('google_recaptcha')->default(false);
            $table->string('submit_button_text')->nullable();
            $table->longText('message')->nullable();
            $table->string('source_id')->nullable();
            $table->string('department_id')->nullable();
            $table->string('type_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('forms', function ($table) {
            $table->dropColumn('type_id');
            $table->dropColumn('department_id');
            $table->dropColumn('source_id');
            $table->dropColumn('message');
            $table->dropColumn('submit_button_text');
            $table->dropColumn('google_recaptcha');
        });
    }
}
