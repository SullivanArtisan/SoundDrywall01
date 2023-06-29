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
            $table->timestamps();
			$table->string('job_proj_id');
            $table->string('job_status');
            $table->string('job_type');
            $table->string('job_address');
            $table->string('job_city');
            $table->string('job_province');
            $table->string('job_desc')->nullable();
            $table->timestamp('job_finished_on')->nullable();
			$table->char('job_deleted', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
