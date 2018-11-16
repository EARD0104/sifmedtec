<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupThemeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_theme', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->unsignedInteger('theme_id');
            $table->foreign('theme_id')->references('id')->on('themes');
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
        Schema::dropIfExists('group_theme');
    }
}
