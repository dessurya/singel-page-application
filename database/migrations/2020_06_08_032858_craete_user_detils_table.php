<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CraeteUserDetilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prof_user_detils', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date_of_birth');
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('education')->nullable();
            $table->string('project_code')->nullable();
            $table->string('project_name')->nullable();
            $table->string('group_cos')->nullable();
            $table->string('current_companies')->nullable();
            $table->string('industry')->nullable();
            $table->string('work_title')->nullable();
            $table->string('level')->nullable();
            $table->string('competencies')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('prof_user_detils', function($table) {
            $table->foreign('user_id')->references('id')->on('prof_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prof_user_detils');
    }
}
