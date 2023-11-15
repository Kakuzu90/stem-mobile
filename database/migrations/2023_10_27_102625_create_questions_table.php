<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->text('direction')->nullable();
            $table->integer('question_type');
            $table->text('with_image_path')->nullable();
            $table->text('choices')->nullable();
            $table->text('answer')->nullable();
            $table->integer('points');
            $table->foreignId('activity_section_id')->constrained()->cascadeOnDelete();
            $table->integer('is_deleted')->default(0)->comment('1 deleted 0 active');
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
        Schema::dropIfExists('questions');
    }
}
