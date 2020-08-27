<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Model\Transaction;
use App\Model\Criteria;
use App\Model\Competencies;
use DB;

class TransactionProfillingGenerateResault extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transProf:generateResault {--transaction=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transaction Proffiling Generate Resault';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('transaction') !== null){
            $this->generate($this->option('transaction'));
        }else{
            Log::error('Transaction Proffiling Generate Resault Not Found Transaction Id');
        }
    }

    public function generate($transaction_id)
    {
        $response = [];
        $Transaction = Transaction::find($transaction_id);
        $Criteria = Criteria::select('id','criteria')->where('status','Y')->orderBy('id','asc')->get();
        foreach ($Criteria as $cRow) {
            $generate = [
                'criteria' => $cRow,
                'resault' => []
            ];
            $generate['criteria']['max_competencies'] = 1;
            $generate['criteria']['max_criteria_count'] = 0;
            $queryGetCompetencies = 'SELECT DISTINCT competencies FROM prof_profilling WHERE criteria = ^criteria^';
            $queryGetCompetencies = str_replace(['^criteria^'], [$cRow->id], $queryGetCompetencies);
            $resultQueryGetCompetencies = DB::select(DB::raw($queryGetCompetencies));
            foreach ($resultQueryGetCompetencies as $competencies_id) {
                $competencies_id = $competencies_id->competencies;
                $competencies_name = Competencies::find($competencies_id)->competencies;
                $queryGetResult = 'SELECT COUNT(competencies) AS count FROM prof_transaction_detils WHERE transaction = ^transaction^ AND criteria = ^criteria^ AND competencies = ^competencies^';
                $queryGetResult = str_replace(['^transaction^','^criteria^','^competencies^'], [$transaction_id,$cRow->id,$competencies_id], $queryGetResult);
                $resultQueryGetResult = DB::select(DB::raw($queryGetResult));
                $resultQueryGetResult = $resultQueryGetResult[0];
                $generate['resault'][] = [
                    'competencies_id' => $competencies_id,
                    'competencies_name' => $competencies_name,
                    'real_resault' => $resultQueryGetResult->count,
                    'revision_resault' => $resultQueryGetResult->count
                ];
                $generate['criteria']['max_criteria_count'] += $resultQueryGetResult->count;
                $generate['criteria']['max_competencies'] += 1;
            }
            $response[] = $generate;
        }
        
        $query = "
			SELECT
				prof_competencies.competencies AS competencies,
				count
			FROM(
				SELECT 
					competencies,
					count(competencies) as count
				FROM
					prof_transaction_detils ptd
				WHERE
					transaction = ^idOfTransaction^
				GROUP BY
					competencies
			) trs
			LEFT JOIN
				prof_competencies on trs.competencies = prof_competencies.id
			ORDER BY count DESC
		";
		$query = str_replace(['^idOfTransaction^'], [$transaction_id], $query);
		$getCompetenciesResault = DB::select(DB::raw($query));

		$Transaction->competencies = $getCompetenciesResault[0]->competencies;
		$Transaction->result = json_encode($response);
		$Transaction->save();
        Log::notice('Transaction Proffiling Generate Resault Success');
    }
}
