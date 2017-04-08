<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function(Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->text('contact_info');
            $table->text('price');
            $table->string('image_path');
            $table->boolean('accepted');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('components_categories')->onDelete('no action');
            $table->integer('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('no action');
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
        Schema::drop('components');
    }
}
