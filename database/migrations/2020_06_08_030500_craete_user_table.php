<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CraeteUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prof_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->uniqe();
            $table->string('status')->default('Y');
            $table->string('password')->nullable();
            $table->string('picture')->nullable();
            $table->bigInteger('roll_id')->nullable()->unsigned();
            $table->rememberToken();
            $table->string('send',1)->default('Y');
            $table->timestamps();
        });

        Schema::table('prof_user', function($table) {
            $table->foreign('roll_id')->references('id')->on('prof_role')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prof_user');
    }
}
