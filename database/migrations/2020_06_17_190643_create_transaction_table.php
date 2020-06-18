<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prof_transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('name');
            $table->string('phone');
            $table->string('consultant')->nullable();
            $table->string('competencies')->nullable();
            $table->string('status')->default('Pending');
            $table->text('note')->nullable();
            $table->text('result')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('prof_transaction', function($table) {
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
        Schema::dropIfExists('prof_transaction');
    }
}
