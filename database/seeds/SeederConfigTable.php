<?php

use Illuminate\Database\Seeder;
use App\Model\Config;

class SeederConfigTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
    	$store = [];
    	$store[] = [
    		'accKey' => 'group_access_for_role_form',
    		'config' => '{"group_access":[{"name":"User&AdminAccess","tab":"uar","access_key":[{"name":"MasterUser","key":"uarUser","option":["view","add","edit","Activated/Inactivated","template","upload"]},{"name":"MasterAdmin","key":"uarAdmin","option":["view","add","edit","Activated/Inactivated"]},{"name":"MasterRole","key":"uarRole","option":["view","add","edit","Activated/Inactivated"]}]},{"name":"MasterData","tab":"master","access_key":[{"name":"MaritalStatus","key":"masterMarital","option":["view","add","edit","Activated/Inactivated"]},{"name":"Religion","key":"masterReligion","option":["view","add","edit","Activated/Inactivated"]},{"name":"Industry","key":"masterIndustry","option":["view","add","edit","Activated/Inactivated"]},{"name":"Level","key":"masterLevel","option":["view","add","edit","Activated/Inactivated"]},{"name":"Education","key":"masterEducation","option":["view","add","edit","Activated/Inactivated"]},{"name":"Competencies","key":"masterCompetencies","option":["view","add","edit","Activated/Inactivated"]}]},{"name":"ProfillingData","tab":"profilling","access_key":[{"name":"Question","key":"profillingQuestion","option":["view","add","edit","Activated/Inactivated"]},{"name":"Answer","key":"profillingAnswer","option":["view","add","edit","Activated/Inactivated"]},{"name":"Competencies","key":"profillingCompetencies","option":["view","add","edit","Activated/Inactivated"]},{"name":"Profilling","key":"profilling","option":["view","add","edit","Activated/Inactivated","template","upload"]}]},{"name":"Transaction","tab":"transaction","access_key":[{"name":"TransactionData","key":"transaction","option":["view","revision/finalise"]},{"name":"Report","key":"report","option":["view"]}]}]}'
    	];
    	$store[] = [
    		'accKey' => 'uarUser',
    		'config' => '{"template":"template/User_Template.xlsx","templateCheck":["Name","Email","DateOfBirth","Handphone","Gender","Religion","MaritalStatus","Education","ProjectCode","ProjectName","GroupCo\'s","CurrentCompanis","Industry","WorkTitle","Level","Competencies","Status"],"table":{"config":[{"data":"email","name":"email","searchable":true,"orderable":true},{"data":"name","name":"name","searchable":true,"orderable":true},{"data":"phone","name":"phone","searchable":true,"orderable":true},{"data":"gender","name":"gender","searchable":true,"orderable":true},{"data":"education","name":"education","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"Vuser","sortBy":["name","desc"],"search":true}}'
    	];
    	$store[] = [
    		'accKey' => 'uarAdmin',
    		'config' => '{"table":{"config":[{"data":"email","name":"email","searchable":true,"orderable":true},{"data":"name","name":"name","searchable":true,"orderable":true},{"data":"role","name":"role","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"Vadmin","sortBy":["name","desc"]}}'
    	];
    	$store[] = [
    		'accKey' => 'uarRole',
    		'config' => '{"table":{"config":[{"data":"name","name":"name","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"Vrole","sortBy":["name","desc"]}}'
    	];
    	$store[] = [
    		'accKey' => 'masterCompetencies',
    		'config' => '{"table":{"config":[{"data":"value","name":"value","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"VmCompetencies","sortBy":["value","desc"]}}'
    	];
    	$store[] = [
    		'accKey' => 'masterEducation',
    		'config' => '{"table":{"config":[{"data":"value","name":"value","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"VmEducation","sortBy":["value","desc"]}}'
    	];
    	$store[] = [
    		'accKey' => 'masterMarital',
    		'config' => '{"table":{"config":[{"data":"value","name":"value","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"VmMarital","sortBy":["value","desc"]}}'
    	];
    	$store[] = [
    		'accKey' => 'masterReligion',
    		'config' => '{"table":{"config":[{"data":"value","name":"value","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"VmReligion","sortBy":["value","desc"]}}'
    	];
    	$store[] = [
    		'accKey' => 'masterIndustry',
    		'config' => '{"table":{"config":[{"data":"value","name":"value","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"VmIndustry","sortBy":["value","desc"]}}'
    	];
    	$store[] = [
    		'accKey' => 'masterLevel',
    		'config' => '{"table":{"config":[{"data":"value","name":"value","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"VmLevel","sortBy":["value","desc"]}}'
    	];
    	$store[] = [
    		'accKey' => 'profillingQuestion',
    		'config' => '{"table":{"config":[{"data":"criteria","name":"criteria","searchable":true,"orderable":true},{"data":"question","name":"question","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"VpQuestion","valOfField":"question","sortBy":["criteria","desc"]}}'
    	];
    	$store[] = [
    		'accKey' => 'profillingAnswer',
    		'config' => '{"table":{"config":[{"data":"answer","name":"answer","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"VpAnswer","valOfField":"answer","sortBy":["answer","desc"]}}'
    	];
    	$store[] = [
    		'accKey' => 'profillingCompetencies',
    		'config' => '{"table":{"config":[{"data":"competencies","name":"competencies","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"VpCompetencies","valOfField":"competencies","sortBy":["competencies","desc"]}}'
    	];
    	$store[] = [
    		'accKey' => 'profilling',
    		'config' => '{"template":"template/Profilling_Template.xlsx","templateCheck":["Criteria","Question","Answer","Competencies","Status"],"table":{"config":[{"data":"criteria","name":"criteria","searchable":true,"orderable":true},{"data":"question","name":"question","searchable":true,"orderable":true},{"data":"answer","name":"answer","searchable":true,"orderable":true},{"data":"competencies","name":"competencies","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"VpProfilling","sortBy":["criteria","desc"]}}'
    	];
    	$store[] = [
    		'accKey' => 'selfProfillingHistory',
    		'config' => '{"table":{"config":[{"data":"created","name":"created","searchable":true,"orderable":true},{"data":"email","name":"email","searchable":true,"orderable":true},{"data":"name","name":"name","searchable":true,"orderable":true},{"data":"phone","name":"handphone","searchable":true,"orderable":true},{"data":"consultant","name":"consultant","searchable":true,"orderable":true},{"data":"competencies","name":"competencies","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"Vtransaction","sortBy":["name","desc"]}}'
    	];
    	$store[] = [
    		'accKey' => 'transaction',
    		'config' => '{"table":{"config":[{"data":"created","name":"created","searchable":true,"orderable":true},{"data":"email","name":"email","searchable":true,"orderable":true},{"data":"name","name":"name","searchable":true,"orderable":true},{"data":"phone","name":"handphone","searchable":true,"orderable":true},{"data":"consultant","name":"consultant","searchable":true,"orderable":true},{"data":"competencies","name":"competencies","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"Vtransaction","sortBy":["name","desc"]}}'
    	];
        foreach ($store as $row) {
            $store = new Config;
            $store->accKey = $row['accKey'];
            $store->config = $row['config'];
            $store->save();
        }
    }
}
