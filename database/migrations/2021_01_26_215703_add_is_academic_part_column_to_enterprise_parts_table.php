<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAcademicPartColumnToEnterprisePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enterprise_parts', function (Blueprint $table) {
            $table->boolean('is_academic_part')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enterprise_parts', function (Blueprint $table) {
            //
        });
    }
}
