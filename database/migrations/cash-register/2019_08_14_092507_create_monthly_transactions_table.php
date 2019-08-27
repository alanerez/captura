<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthlyTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('month');
            $table->string('transactions');
            $table->string('legal');
            $table->string('admin');
            $table->string('sales_comm');
            $table->string('admin_comm');
            $table->string('notary');
            $table->string('sales');
            $table->string('debt_onboarded');
            $table->string('sales_lifetime');
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
        Schema::dropIfExists('monthly_transactions');
    }
}
