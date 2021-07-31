<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScholarshipApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scholarship_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scholarship_id');
            $table->foreignId('student_id');
            $table->foreignId('course_id');
            $table->integer('year_level');
            $table->integer('sem');
            $table->string('sy', 9);
            $table->decimal('gpa', 3);
            $table->decimal('lowest_grade', 3);
            $table->integer('num_of_units');
            $table->boolean('has_inc');
            $table->boolean('has_drop');
            $table->string('status', 30)->default('REQUIREMENTS FOR UPLOAD');
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
        Schema::dropIfExists('scholarship_applications');
    }
}
