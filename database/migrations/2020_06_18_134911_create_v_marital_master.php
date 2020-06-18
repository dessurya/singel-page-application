<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVMaritalMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW prof_vm_marital AS (
                SELECT 
                    id,
                    type,
                    value,
                    status
                FROM prof_master WHERE type = 'marital'
            )
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS prof_vm_marital");
    }
}
