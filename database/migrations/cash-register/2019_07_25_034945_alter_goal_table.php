<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goal', function(Blueprint $table) {
            $table->renameColumn('type', 'monthly_income');
            $table->renameColumn('value', 'growth');
            $table->string('transactions')->after('id');
            $table->string('monthly_debt')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goal', function(Blueprint $table) {
            $table->renameColumn('monthly_income', 'type');
            $table->renameColumn('growth', 'value');
            $table->dropColumn(['transactions', 'monthly_debt']);
        });
    }
}
