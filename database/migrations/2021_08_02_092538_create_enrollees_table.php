<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrolleesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id');
            $table->string('sy', 9);
            $table->integer('sem');
            $table->integer('year_level');
            $table->integer('num_of_enrollee', false, true)->default(0);
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
        Schema::dropIfExists('enrollees');
    }
}
