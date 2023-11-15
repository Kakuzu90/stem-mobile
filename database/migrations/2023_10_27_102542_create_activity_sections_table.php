<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitySectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('direction');
            $table->foreignId('activity_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('activity_sections');
    }
}
