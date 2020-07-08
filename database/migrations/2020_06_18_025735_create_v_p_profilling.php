<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVPProfilling extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW prof_vp_profilling AS (
                SELECT 
                    p.id AS id,
                    cr.id AS criteria_id,
                    cr.criteria AS criteria,
                    q.question AS question,
                    q.id AS question_id,
                    a.answer AS answer,
                    a.id AS answer_id,
                    c.competencies AS competencies,
                    c.id AS competencies_id,
                    p.status AS status
                FROM prof_profilling p
                LEFT JOIN prof_competencies c ON p.competencies = c.id
                LEFT JOIN prof_answer a ON p.answer = a.id
                LEFT JOIN prof_question q ON p.question = q.id
                LEFT JOIN prof_criteria cr ON p.criteria = cr.id
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
        DB::statement("DROP VIEW IF EXISTS prof_vp_profilling");
    }
}
