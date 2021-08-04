<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scholarship_id');
            $table->decimal('gpa_max', 3, 2)->default(1.00);
            $table->decimal('gpa_min', 3, 2)->default(5.00);
            $table->decimal('lowest_grade', 3, 2)->default(5.00);
            $table->integer('minimum_units')->default(0);
            $table->boolean('allow_drop', 10)->default(0);
            $table->boolean('allow_inc')->default(0);
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
        Schema::dropIfExists('qualifications');
    }
}
