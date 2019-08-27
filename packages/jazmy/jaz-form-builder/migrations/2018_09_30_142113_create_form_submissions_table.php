<?php
/*--------------------
https://github.com/jazmy/laravelformbuilder
Licensed under the GNU General Public License v3.0
Author: Jasmine Robinson (jazmy.com)
Last Updated: 12/29/2018
----------------------*/
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->string('id')->primary();

            $table->string('form_id')->nullable();

            $table->string('user_id')->nullable();

            $table->text('content');

            $table->softDeletes();
            $table->timestamps();

            // $table->foreign('form_id')->references('id')->on('forms')->onDelete('CASCADE');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_submissions');
    }
}
