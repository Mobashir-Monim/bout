<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseEvaluationAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_evaluation_analyses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->string('semester')->nullable();
            $table->string('department')->nullable();
            $table->string('course')->nullable();
            $table->json('dataset');
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
        Schema::dropIfExists('course_evaluation_analyses');
    }
}
