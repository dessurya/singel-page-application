<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prof_profilling', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status')->default('N');
            $table->bigInteger('question')->nullable()->unsigned();
            $table->bigInteger('answer')->nullable()->unsigned();
            $table->bigInteger('competencies')->nullable()->unsigned();
            $table->timestamps();
        });

        Schema::table('prof_profilling', function($table) {
            $table->foreign('question')->references('id')->on('prof_question')->onDelete('set null');
            $table->foreign('answer')->references('id')->on('prof_answer')->onDelete('set null');
            $table->foreign('competencies')->references('id')->on('prof_competencies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prof_profilling');
    }
}
