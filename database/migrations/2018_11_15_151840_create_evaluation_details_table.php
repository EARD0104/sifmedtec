<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('evaluation_id');
            $table->foreign('evaluation_id')->references('id')->on('evaluations');
            $table->unsignedInteger('area_id');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->unsignedInteger('answer_id');
            $table->foreign('answer_id')->references('id')->on('answers');
            $table->boolean('answer')->default(0);
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
        Schema::dropIfExists('evaluation_details');
    }
}
