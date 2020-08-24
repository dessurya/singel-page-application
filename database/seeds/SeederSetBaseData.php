<?php

use Illuminate\Database\Seeder;
use App\Model\Master;
use App\Model\Criteria;
use App\Model\Question;
use App\Model\Answer;
use App\Model\Competencies;
use App\Model\Profilling;
use App\Model\User;
use App\Model\UserDetils;
use App\Model\Transaction;
use App\Model\TransactionDetils;

class SeederSetBaseData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->MasterData();
        $this->Criteria();
        $this->Question();
        $this->Answer();
        $this->Competencies();
        $this->Profilling();
        $this->UserData();
        $this->transactionFeedData();
    }

    public function MasterData()
    {
        $stores = [
            ['type'=>'competencies', 'value'=>'competencies_1'],
            ['type'=>'competencies', 'value'=>'competencies_2'],
            ['type'=>'competencies', 'value'=>'competencies_3'],
            ['type'=>'competencies', 'value'=>'competencies_4'],

            ['type'=>'education', 'value'=>'education_1'],
            ['type'=>'education', 'value'=>'education_2'],
            ['type'=>'education', 'value'=>'education_3'],
            ['type'=>'education', 'value'=>'education_4'],

            ['type'=>'industry', 'value'=>'industry_1'],
            ['type'=>'industry', 'value'=>'industry_2'],
            ['type'=>'industry', 'value'=>'industry_3'],
            ['type'=>'industry', 'value'=>'industry_4'],

            ['type'=>'level', 'value'=>'level_1'],
            ['type'=>'level', 'value'=>'level_2'],
            ['type'=>'level', 'value'=>'level_3'],
            ['type'=>'level', 'value'=>'level_4'],

            ['type'=>'marital', 'value'=>'marital_1'],
            ['type'=>'marital', 'value'=>'marital_2'],

            ['type'=>'religion', 'value'=>'religion_1'],
            ['type'=>'religion', 'value'=>'religion_2'],
            ['type'=>'religion', 'value'=>'religion_3'],
            ['type'=>'religion', 'value'=>'religion_4']
        ];
        foreach ($stores as $store) {
            Master::create($store);
        }
    }

    public function UserData()
    {
        $stores =[
            ['name'=>'user 001','email'=>'user001@mail.mail','roll_id'=>2,'password'=>'useruser'],
            ['name'=>'user 002','email'=>'user002@mail.mail','roll_id'=>2,'password'=>'useruser'],
            ['name'=>'user 003','email'=>'user003@mail.mail','roll_id'=>2,'password'=>'useruser'],
            ['name'=>'user 004','email'=>'user004@mail.mail','roll_id'=>2,'password'=>'useruser'],
            ['name'=>'user 005','email'=>'user005@mail.mail','roll_id'=>2,'password'=>'useruser'],
            ['name'=>'user 006','email'=>'user006@mail.mail','roll_id'=>2,'password'=>'useruser']
        ];
        foreach ($stores as $store) {
            $User = User::create($store);
            $UserDetils = new UserDetils;
            $UserDetils->date_of_birth      = '1990/01/01';
            $UserDetils->phone              = '021'.rand(100000,999999);
            $UserDetils->gender             = 'Male';
            $UserDetils->religion           = 'religion_'.rand(1,4);
            $UserDetils->marital_status     = 'marital_'.rand(1,2);
            $UserDetils->education          = 'education_'.rand(1,4);
            $UserDetils->project_code       = 'code-'.rand(100,999);
            $UserDetils->project_name       = 'code-name-'.rand(100,999);
            $UserDetils->group_cos          = 'cos-'.rand(100,999);
            $UserDetils->current_companies  = '-';
            $UserDetils->industry           = 'industry_'.rand(1,4);
            $UserDetils->work_title         = '-';
            $UserDetils->level              = 'level_'.rand(1,4);
            $UserDetils->competencies       = 'competencies_'.rand(1,4);
            $UserDetils->user_id            = $User->id;
            $UserDetils->save();
        }
    }

    public function Criteria()
    {
        $stores = [
            ['criteria'=>'criteria_1', 'description'=>'criteria_description_1'],
            ['criteria'=>'criteria_2', 'description'=>'criteria_description_2'],
            ['criteria'=>'criteria_3', 'description'=>'criteria_description_3'],
            ['criteria'=>'criteria_4', 'description'=>'criteria_description_4']
        ];
        foreach ($stores as $store) {
            Criteria::create($store);
        }
    }

    public function Question()
    {
        $stores = [
            ['question'=>'question_1', 'sort'=>1],
            ['question'=>'question_2', 'sort'=>2],
            ['question'=>'question_3', 'sort'=>3],
            ['question'=>'question_4', 'sort'=>4],
            ['question'=>'question_5', 'sort'=>5],
            ['question'=>'question_6', 'sort'=>6],
            ['question'=>'question_7', 'sort'=>7],
            ['question'=>'question_8', 'sort'=>8],
            ['question'=>'question_9', 'sort'=>9],
            ['question'=>'question_10', 'sort'=>10],
            ['question'=>'question_11', 'sort'=>11],
            ['question'=>'question_12', 'sort'=>12],
            ['question'=>'question_13', 'sort'=>13],
            ['question'=>'question_14', 'sort'=>14],
            ['question'=>'question_15', 'sort'=>15],
            ['question'=>'question_16', 'sort'=>16],
            ['question'=>'question_17', 'sort'=>17],
            ['question'=>'question_18', 'sort'=>18],
            ['question'=>'question_19', 'sort'=>19],
            ['question'=>'question_20', 'sort'=>20],
        ];
        foreach ($stores as $store) {
            Question::create($store);
        }
    }

    public function Answer()
    {
        $stores = [
            ['answer'=>'answer_1'],
            ['answer'=>'answer_2'],
            ['answer'=>'answer_3'],
            ['answer'=>'answer_4'],
            ['answer'=>'answer_5'],
            ['answer'=>'answer_6'],
            ['answer'=>'answer_7'],
            ['answer'=>'answer_8'],
            ['answer'=>'answer_9'],
            ['answer'=>'answer_10'],
            ['answer'=>'answer_11'],
            ['answer'=>'answer_12'],
            ['answer'=>'answer_13'],
            ['answer'=>'answer_14'],
            ['answer'=>'answer_15'],
            ['answer'=>'answer_16'],
            ['answer'=>'answer_17'],
            ['answer'=>'answer_18'],
            ['answer'=>'answer_19'],
            ['answer'=>'answer_20']
        ];
        foreach ($stores as $store) {
            Answer::create($store);
        }
    }

    public function Competencies()
    {
        $stores = [
            ['competencies'=>'competencies_1'],
            ['competencies'=>'competencies_2'],
            ['competencies'=>'competencies_3'],
            ['competencies'=>'competencies_4']
        ];
        foreach ($stores as $store) {
            Competencies::create($store);
        }
    }

    public function Profilling()
    {
        $stores = [
            ['criteria'=>1, 'question'=>1, 'answer'=>1, 'competencies'=>1],
            ['criteria'=>2, 'question'=>1, 'answer'=>2, 'competencies'=>2],
            ['criteria'=>3, 'question'=>1, 'answer'=>3, 'competencies'=>3],
            ['criteria'=>4, 'question'=>1, 'answer'=>4, 'competencies'=>4],

            ['criteria'=>1, 'question'=>2, 'answer'=>5, 'competencies'=>1],
            ['criteria'=>2, 'question'=>2, 'answer'=>6, 'competencies'=>2],
            ['criteria'=>3, 'question'=>2, 'answer'=>7, 'competencies'=>3],
            ['criteria'=>4, 'question'=>2, 'answer'=>8, 'competencies'=>4],

            ['criteria'=>1, 'question'=>3, 'answer'=>9, 'competencies'=>1],
            ['criteria'=>2, 'question'=>3, 'answer'=>10, 'competencies'=>2],
            ['criteria'=>3, 'question'=>3, 'answer'=>11, 'competencies'=>3],
            ['criteria'=>4, 'question'=>3, 'answer'=>12, 'competencies'=>4],

            ['criteria'=>1, 'question'=>4, 'answer'=>13, 'competencies'=>1],
            ['criteria'=>2, 'question'=>4, 'answer'=>14, 'competencies'=>2],
            ['criteria'=>3, 'question'=>4, 'answer'=>15, 'competencies'=>3],
            ['criteria'=>4, 'question'=>4, 'answer'=>16, 'competencies'=>4],

            ['criteria'=>1, 'question'=>5, 'answer'=>17, 'competencies'=>1],
            ['criteria'=>2, 'question'=>5, 'answer'=>18, 'competencies'=>2],
            ['criteria'=>3, 'question'=>5, 'answer'=>19, 'competencies'=>3],
            ['criteria'=>4, 'question'=>5, 'answer'=>20, 'competencies'=>4],

            ['criteria'=>1, 'question'=>6, 'answer'=>1, 'competencies'=>1],
            ['criteria'=>2, 'question'=>6, 'answer'=>2, 'competencies'=>2],
            ['criteria'=>3, 'question'=>6, 'answer'=>3, 'competencies'=>3],
            ['criteria'=>4, 'question'=>6, 'answer'=>4, 'competencies'=>4],

            ['criteria'=>1, 'question'=>7, 'answer'=>5, 'competencies'=>1],
            ['criteria'=>2, 'question'=>7, 'answer'=>6, 'competencies'=>2],
            ['criteria'=>3, 'question'=>7, 'answer'=>7, 'competencies'=>3],
            ['criteria'=>4, 'question'=>7, 'answer'=>8, 'competencies'=>4],

            ['criteria'=>1, 'question'=>8, 'answer'=>9, 'competencies'=>1],
            ['criteria'=>2, 'question'=>8, 'answer'=>10, 'competencies'=>2],
            ['criteria'=>3, 'question'=>8, 'answer'=>11, 'competencies'=>3],
            ['criteria'=>4, 'question'=>8, 'answer'=>12, 'competencies'=>4],

            ['criteria'=>1, 'question'=>9, 'answer'=>13, 'competencies'=>1],
            ['criteria'=>2, 'question'=>9, 'answer'=>14, 'competencies'=>2],
            ['criteria'=>3, 'question'=>9, 'answer'=>15, 'competencies'=>3],
            ['criteria'=>4, 'question'=>9, 'answer'=>16, 'competencies'=>4],

            ['criteria'=>1, 'question'=>10, 'answer'=>17, 'competencies'=>1],
            ['criteria'=>2, 'question'=>10, 'answer'=>18, 'competencies'=>2],
            ['criteria'=>3, 'question'=>10, 'answer'=>19, 'competencies'=>3],
            ['criteria'=>4, 'question'=>10, 'answer'=>20, 'competencies'=>4],

            ['criteria'=>1, 'question'=>11, 'answer'=>1, 'competencies'=>1],
            ['criteria'=>2, 'question'=>11, 'answer'=>2, 'competencies'=>2],
            ['criteria'=>3, 'question'=>11, 'answer'=>3, 'competencies'=>3],
            ['criteria'=>4, 'question'=>11, 'answer'=>4, 'competencies'=>4],

            ['criteria'=>1, 'question'=>12, 'answer'=>5, 'competencies'=>1],
            ['criteria'=>2, 'question'=>12, 'answer'=>6, 'competencies'=>2],
            ['criteria'=>3, 'question'=>12, 'answer'=>7, 'competencies'=>3],
            ['criteria'=>4, 'question'=>12, 'answer'=>8, 'competencies'=>4],

            ['criteria'=>1, 'question'=>13, 'answer'=>9, 'competencies'=>1],
            ['criteria'=>2, 'question'=>13, 'answer'=>10, 'competencies'=>2],
            ['criteria'=>3, 'question'=>13, 'answer'=>11, 'competencies'=>3],
            ['criteria'=>4, 'question'=>13, 'answer'=>12, 'competencies'=>4],

            ['criteria'=>1, 'question'=>14, 'answer'=>13, 'competencies'=>1],
            ['criteria'=>2, 'question'=>14, 'answer'=>14, 'competencies'=>2],
            ['criteria'=>3, 'question'=>14, 'answer'=>15, 'competencies'=>3],
            ['criteria'=>4, 'question'=>14, 'answer'=>16, 'competencies'=>4],

            ['criteria'=>1, 'question'=>15, 'answer'=>17, 'competencies'=>1],
            ['criteria'=>2, 'question'=>15, 'answer'=>18, 'competencies'=>2],
            ['criteria'=>3, 'question'=>15, 'answer'=>19, 'competencies'=>3],
            ['criteria'=>4, 'question'=>15, 'answer'=>20, 'competencies'=>4],

            ['criteria'=>1, 'question'=>16, 'answer'=>1, 'competencies'=>1],
            ['criteria'=>2, 'question'=>16, 'answer'=>2, 'competencies'=>2],
            ['criteria'=>3, 'question'=>16, 'answer'=>3, 'competencies'=>3],
            ['criteria'=>4, 'question'=>16, 'answer'=>4, 'competencies'=>4],

            ['criteria'=>1, 'question'=>17, 'answer'=>5, 'competencies'=>1],
            ['criteria'=>2, 'question'=>17, 'answer'=>6, 'competencies'=>2],
            ['criteria'=>3, 'question'=>17, 'answer'=>7, 'competencies'=>3],
            ['criteria'=>4, 'question'=>17, 'answer'=>8, 'competencies'=>4],

            ['criteria'=>1, 'question'=>18, 'answer'=>9, 'competencies'=>1],
            ['criteria'=>2, 'question'=>18, 'answer'=>10, 'competencies'=>2],
            ['criteria'=>3, 'question'=>18, 'answer'=>11, 'competencies'=>3],
            ['criteria'=>4, 'question'=>18, 'answer'=>12, 'competencies'=>4],

            ['criteria'=>1, 'question'=>19, 'answer'=>13, 'competencies'=>1],
            ['criteria'=>2, 'question'=>19, 'answer'=>14, 'competencies'=>2],
            ['criteria'=>3, 'question'=>19, 'answer'=>15, 'competencies'=>3],
            ['criteria'=>4, 'question'=>19, 'answer'=>16, 'competencies'=>4],

            ['criteria'=>1, 'question'=>20, 'answer'=>17, 'competencies'=>1],
            ['criteria'=>2, 'question'=>20, 'answer'=>18, 'competencies'=>2],
            ['criteria'=>3, 'question'=>20, 'answer'=>19, 'competencies'=>3],
            ['criteria'=>4, 'question'=>20, 'answer'=>20, 'competencies'=>4],
        ];
        foreach ($stores as $store) {
            Profilling::create($store);
        }
    }

    public function transactionFeedData()
    {
        $transD = [
            'user001@mail.mail'=>[
                ['profilling'=>1,'question'=>1,'answer'=>1,'criteria'=>1,'competencies'=>1],
                ['profilling'=>5,'question'=>2,'answer'=>5,'criteria'=>1,'competencies'=>1],
                ['profilling'=>9,'question'=>3,'answer'=>9,'criteria'=>1,'competencies'=>1],
                ['profilling'=>13,'question'=>4,'answer'=>13,'criteria'=>1,'competencies'=>1],
                ['profilling'=>17,'question'=>5,'answer'=>17,'criteria'=>1,'competencies'=>1],
                ['profilling'=>21,'question'=>6,'answer'=>1,'criteria'=>1,'competencies'=>1],
                ['profilling'=>25,'question'=>7,'answer'=>5,'criteria'=>1,'competencies'=>1],
                ['profilling'=>29,'question'=>8,'answer'=>9,'criteria'=>1,'competencies'=>1],
                ['profilling'=>33,'question'=>9,'answer'=>13,'criteria'=>1,'competencies'=>1],
                ['profilling'=>37,'question'=>10,'answer'=>17,'criteria'=>1,'competencies'=>1],
                ['profilling'=>41,'question'=>11,'answer'=>1,'criteria'=>1,'competencies'=>1],
                ['profilling'=>45,'question'=>12,'answer'=>5,'criteria'=>1,'competencies'=>1],
                ['profilling'=>49,'question'=>13,'answer'=>9,'criteria'=>1,'competencies'=>1],
                ['profilling'=>53,'question'=>14,'answer'=>13,'criteria'=>1,'competencies'=>1],
                ['profilling'=>57,'question'=>15,'answer'=>17,'criteria'=>1,'competencies'=>1],
                ['profilling'=>61,'question'=>16,'answer'=>1,'criteria'=>1,'competencies'=>1],
                ['profilling'=>65,'question'=>17,'answer'=>5,'criteria'=>1,'competencies'=>1],
                ['profilling'=>69,'question'=>18,'answer'=>9,'criteria'=>1,'competencies'=>1],
                ['profilling'=>73,'question'=>19,'answer'=>13,'criteria'=>1,'competencies'=>1],
                ['profilling'=>77,'question'=>20,'answer'=>17,'criteria'=>1,'competencies'=>1],
            ],
            'user002@mail.mail'=>[
                ['profilling'=>2,'question'=>1,'answer'=>2,'criteria'=>2,'competencies'=>2],
                ['profilling'=>6,'question'=>2,'answer'=>6,'criteria'=>2,'competencies'=>2],
                ['profilling'=>10,'question'=>3,'answer'=>10,'criteria'=>2,'competencies'=>2],
                ['profilling'=>14,'question'=>4,'answer'=>14,'criteria'=>2,'competencies'=>2],
                ['profilling'=>18,'question'=>5,'answer'=>18,'criteria'=>2,'competencies'=>2],
                ['profilling'=>22,'question'=>6,'answer'=>2,'criteria'=>2,'competencies'=>2],
                ['profilling'=>26,'question'=>7,'answer'=>6,'criteria'=>2,'competencies'=>2],
                ['profilling'=>30,'question'=>8,'answer'=>10,'criteria'=>2,'competencies'=>2],
                ['profilling'=>34,'question'=>9,'answer'=>14,'criteria'=>2,'competencies'=>2],
                ['profilling'=>38,'question'=>10,'answer'=>18,'criteria'=>2,'competencies'=>2],
                ['profilling'=>42,'question'=>11,'answer'=>2,'criteria'=>2,'competencies'=>2],
                ['profilling'=>46,'question'=>12,'answer'=>6,'criteria'=>2,'competencies'=>2],
                ['profilling'=>50,'question'=>13,'answer'=>10,'criteria'=>2,'competencies'=>2],
                ['profilling'=>54,'question'=>14,'answer'=>14,'criteria'=>2,'competencies'=>2],
                ['profilling'=>58,'question'=>15,'answer'=>18,'criteria'=>2,'competencies'=>2],
                ['profilling'=>62,'question'=>16,'answer'=>2,'criteria'=>2,'competencies'=>2],
                ['profilling'=>66,'question'=>17,'answer'=>6,'criteria'=>2,'competencies'=>2],
                ['profilling'=>70,'question'=>18,'answer'=>10,'criteria'=>2,'competencies'=>2],
                ['profilling'=>74,'question'=>19,'answer'=>14,'criteria'=>2,'competencies'=>2],
                ['profilling'=>78,'question'=>20,'answer'=>18,'criteria'=>2,'competencies'=>2],
            ],
            'user003@mail.mail' => [
                ['profilling'=>1,'question'=>1,'answer'=>1,'criteria'=>1,'competencies'=>1],
                ['profilling'=>5,'question'=>2,'answer'=>5,'criteria'=>1,'competencies'=>1],
                ['profilling'=>10,'question'=>3,'answer'=>10,'criteria'=>2,'competencies'=>2],
                ['profilling'=>14,'question'=>4,'answer'=>14,'criteria'=>2,'competencies'=>2],
                ['profilling'=>17,'question'=>5,'answer'=>17,'criteria'=>1,'competencies'=>1],
                ['profilling'=>21,'question'=>6,'answer'=>1,'criteria'=>1,'competencies'=>1],
                ['profilling'=>26,'question'=>7,'answer'=>6,'criteria'=>2,'competencies'=>2],
                ['profilling'=>30,'question'=>8,'answer'=>10,'criteria'=>2,'competencies'=>2],
                ['profilling'=>33,'question'=>9,'answer'=>13,'criteria'=>1,'competencies'=>1],
                ['profilling'=>37,'question'=>10,'answer'=>17,'criteria'=>1,'competencies'=>1],
                ['profilling'=>41,'question'=>11,'answer'=>1,'criteria'=>1,'competencies'=>1],
                ['profilling'=>45,'question'=>12,'answer'=>5,'criteria'=>1,'competencies'=>1],
                ['profilling'=>49,'question'=>13,'answer'=>9,'criteria'=>1,'competencies'=>1],
                ['profilling'=>53,'question'=>14,'answer'=>13,'criteria'=>1,'competencies'=>1],
                ['profilling'=>57,'question'=>15,'answer'=>17,'criteria'=>1,'competencies'=>1],
                ['profilling'=>61,'question'=>16,'answer'=>1,'criteria'=>1,'competencies'=>1],
                ['profilling'=>65,'question'=>17,'answer'=>5,'criteria'=>1,'competencies'=>1],
                ['profilling'=>69,'question'=>18,'answer'=>9,'criteria'=>1,'competencies'=>1],
                ['profilling'=>74,'question'=>19,'answer'=>14,'criteria'=>2,'competencies'=>2],
                ['profilling'=>78,'question'=>20,'answer'=>18,'criteria'=>2,'competencies'=>2],
            ],
            'user001@mail.mail.comp' => [
                'single' => 'competencies_1',
                'encode' => [
                    'competencies' => [
                        ['competencies' => 'competencies_1', 'count'=>20]
                    ]
                ]
            ],
            'user002@mail.mail.comp' => [
                'single' => 'competencies_2',
                'encode' => [
                    'competencies' => [
                        ['competencies' => 'competencies_2', 'count'=>20]
                    ]
                ]
            ],
            'user003@mail.mail.comp' => [
                'single' => 'competencies_1',
                'encode' => [
                    'competencies' => [
                        ['competencies' => 'competencies_1', 'count'=>14],
                        ['competencies' => 'competencies_2', 'count'=>6]
                    ]
                ]
            ]
        ];
        $Users = User::with('getUserDetils')
        ->whereIn('email',['user001@mail.mail','user002@mail.mail','user003@mail.mail'])
        ->get();
        foreach ($Users as $User) {
            $storeH = new Transaction;
            $storeH->user_id = $User->id;
            $storeH->email = $User->email;
            $storeH->name = $User->name;
            $storeH->competencies = $transD[$User->email.'.comp']['single'];
            $storeH->result = json_encode($transD[$User->email.'.comp']['encode']);
            $storeH->phone = $User->getUserDetils->phone;
            $storeH->save();
            foreach ($transD[$User->email] as $row) {
                $storeD = new TransactionDetils;
                $storeD->question = $row['question'];
                $storeD->profilling = $row['profilling'];
                $storeD->criteria = $row['criteria'];
                $storeD->answer = $row['answer'];
                $storeD->competencies = $row['competencies'];
                $storeD->transaction = $storeH->id;
                $storeD->save();
            }
        }
    }
}
