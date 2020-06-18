<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW prof_v_admin AS (
                SELECT 
                    u.id AS id,
                    u.name AS name,
                    email,
                    r.name AS role,
                    u.status AS status
                FROM prof_user u
                LEFT JOIN prof_role r ON u.roll_id = r.id
                WHERE roll_id != 2
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
        DB::statement("DROP VIEW IF EXISTS prof_v_admin");
    }
}
