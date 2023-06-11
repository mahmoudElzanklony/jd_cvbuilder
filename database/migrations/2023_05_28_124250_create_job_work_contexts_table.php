<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobWorkContextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_work_contexts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('work_id')->constrained('work_contexts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('rank');
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
        Schema::dropIfExists('jobs_work_contexts');
    }
}
