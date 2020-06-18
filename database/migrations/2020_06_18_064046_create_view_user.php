<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW prof_v_user AS (
                SELECT 
                    h.id AS id,
                    name,
                    email,
                    date_of_birth,
                    phone,
                    gender,
                    religion,
                    marital_status,
                    education,
                    project_code,
                    project_name,
                    group_cos,
                    current_companies,
                    industry,
                    work_title,
                    level,
                    competencies,
                    h.created_at as created_at,
                    h.updated_at as updated_at,
                    h.status AS status
                FROM prof_user h
                LEFT JOIN prof_user_detils c ON h.id = c.user_id
                WHERE roll_id = 2
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
        DB::statement("DROP VIEW IF EXISTS prof_v_user");
    }
}
