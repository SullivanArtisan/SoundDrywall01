<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('mtrl_job_id');
            $table->string('mtrl_status');
            $table->string('mtrl_type');
            $table->string('mtrl_size')->nullable();
			$table->decimal('mtrl_amount', 8, 2);
			$table->decimal('mtrl_amount_left', 8, 2)->nullable();
            $table->string('mtrl_unit')->nullable();
            $table->string('mtrl_source_type');
            $table->string('mtrl_shipped_by');
            $table->timestamp('mtrl_finished_on')->nullable();
			$table->char('mtrl_deleted', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
