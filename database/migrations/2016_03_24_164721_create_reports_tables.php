<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('answer_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
            $table->foreign('answer_id')->references('id')->on('answers')->onDelete('CASCADE');
            $table->string('report');
            $table->string('link');

        });

        Schema::create('questions_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('CASCADE');
            $table->string('report');
            $table->string('link');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('answers_reports');
        Schema::drop('question_reports');
    }
}
