<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferedCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offered_courses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('course_id');
            $table->string('run_id', 15);
            $table->string('coordinator')->default(' ');
            $table->string('email')->default(' ');
            $table->string('initials')->default(' ');
            $table->boolean('is_rerun')->default(false);
            $table->string('bux_code')->nullable();
            $table->boolean('is_lab')->default(false);
            $table->boolean('has_lab')->default(false);
            $table->text('evaluation')->nullable();
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
        Schema::dropIfExists('offered_courses');
    }
}
