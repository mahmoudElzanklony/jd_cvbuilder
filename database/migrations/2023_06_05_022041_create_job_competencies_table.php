<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobCompetenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_competencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('competency_id')->constrained('competencies')
                ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('job_competencies');
    }
}
