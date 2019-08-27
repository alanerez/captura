<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->string('source_id')->nullable();
            $table->string('department_id')->nullable();
            $table->string('status_id')->nullable();
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
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->dropColumn('type_id');
            $table->dropColumn('status_id');
            $table->dropColumn('department_id');
            $table->dropColumn('source_id');
        });
    }
}
