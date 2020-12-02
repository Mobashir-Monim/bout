<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferedCourseSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offered_course_sections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('offered_course_id');
            $table->unsignedTinyInteger('section')->unsigned();
            $table->string('name');
            $table->string('initials');
            $table->string('email');
            $table->boolean('is_lab_faculty')->default(false);
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
        Schema::dropIfExists('offered_course_sections');
    }
}
