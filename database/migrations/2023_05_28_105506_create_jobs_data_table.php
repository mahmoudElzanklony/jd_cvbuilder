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
        Schema::create('jobs_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()
                ->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('parent_id')->default(0);
            $table->string('career_ladder');
            $table->string('ar_name');
            $table->string('en_name');
            $table->longText('ar_desc');
            $table->longText('en_desc');
            $table->string('contract_period');
            $table->tinyInteger('contract_renewable');
            $table->string('years_experience');
            $table->float('min_salary');
            $table->float('max_salary');
            $table->string('ar_career_path');
            $table->string('en_career_path');
            $table->string('status');
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
