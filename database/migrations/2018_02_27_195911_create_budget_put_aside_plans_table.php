<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetPutAsidePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_put_aside_plans', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('family_id')->unsigned();
            $table->foreign('family_id')->references('id')->on('families');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');

            $table->integer('amount')->unsigned();
            $table->string('comment')->nullable();

            $table->boolean('type')->default(\App\BudgetPutAsidePlan::TYPE_YEARLY);

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
        Schema::dropIfExists('budget_put_aside_plans');
    }
}
