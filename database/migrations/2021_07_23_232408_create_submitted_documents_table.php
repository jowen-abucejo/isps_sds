<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmittedDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submitted_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scholarship_application_id');
            $table->foreignId('requirement_id');
            $table->string('filename')->nullable();
            $table->string('comments')->nullable();
            $table->string('status')->default('TO UPLOAD');
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
        Schema::dropIfExists('submitted_documents');
    }
}
