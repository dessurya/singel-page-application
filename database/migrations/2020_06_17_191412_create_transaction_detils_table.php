<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prof_transaction_detils', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('transaction')->nullable()->unsigned();
            $table->bigInteger('profilling')->nullable()->unsigned();
            $table->bigInteger('question')->nullable()->unsigned();
            $table->bigInteger('answer')->nullable()->unsigned();
            $table->bigInteger('competencies')->nullable()->unsigned();
        });

        Schema::table('prof_transaction_detils', function($table) {
            $table->foreign('transaction')->references('id')->on('prof_transaction')->onDelete('set null');
            $table->foreign('profilling')->references('id')->on('prof_profilling')->onDelete('set null');
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
        Schema::dropIfExists('prof_transaction_detils');
    }
}
