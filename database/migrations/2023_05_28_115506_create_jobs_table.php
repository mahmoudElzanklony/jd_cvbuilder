<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()
                ->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('parent_id')->default(0);
            $table->string('career_ladder');
            $table->string('name');
            $table->longText('description');
            $table->string('contract_period');
            $table->tinyInteger('contract_renewable');
            $table->string('YEARS_EXPERIENCE');
            $table->float('min_salary');
            $table->float('max_salary');
            $table->string('career_path');
            $table->string('status')->default('a');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs_titles');
    }
}
