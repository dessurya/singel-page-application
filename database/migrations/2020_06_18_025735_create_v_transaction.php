<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW prof_v_transaction AS (
                SELECT 
                    id,
                    user_id,
                    email,
                    name,
                    phone,
                    consultant,
                    competencies,
                    status,
                    created_at AS created
                FROM prof_transaction
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
        DB::statement("DROP VIEW IF EXISTS prof_v_transaction");
    }
}
