<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScholarshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('scholarship_code');
            $table->string('description');
            $table->string('type')->nullable();
            $table->decimal('gpa_max', 3, 2)->default(1.00);
            $table->decimal('gpa_min', 3, 2)->default(5.00);
            $table->decimal('lowest_grade', 3, 2)->nullable();
            $table->string('active')->default('ACTIVE');
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
        Schema::dropIfExists('scholarships');
    }
}
