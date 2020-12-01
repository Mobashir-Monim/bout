<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnterprisePartRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprise_part_relation', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('parent_id');
            $table->unsignedInteger('child_id');
            $table->string('heirarchy')->nullable();
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
        Schema::dropIfExists('enterprise_part_relation');
    }
}
