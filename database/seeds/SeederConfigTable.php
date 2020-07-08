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
    		'config' => '{"group_access":[{"name":"User & Admin Access","tab":"uar","access_key":[{"name":"Master User","key":"uarUser","option":["view","add","edit","Activated/Inactivated","template","upload"]},{"name":"Master Admin","key":"uarAdmin","option":["view","add","edit","Activated/Inactivated"]},{"name":"Master Role","key":"uarRole","option":["view","add","edit","Activated/Inactivated"]}]},{"name":"Master Data","tab":"master","access_key":[{"name":"Marital Status","key":"masterMarital","option":["view","add","edit","Activated/Inactivated"]},{"name":"Religion","key":"masterReligion","option":["view","add","edit","Activated/Inactivated"]},{"name":"Industry","key":"masterIndustry","option":["view","add","edit","Activated/Inactivated"]},{"name":"Level","key":"masterLevel","option":["view","add","edit","Activated/Inactivated"]},{"name":"Education","key":"masterEducation","option":["view","add","edit","Activated/Inactivated"]},{"name":"Competencies","key":"masterCompetencies","option":["view","add","edit","Activated/Inactivated"]}]},{"name":"Profilling Data","tab":"profilling","access_key":[{"name":"Criteria","key":"profillingCriteria","option":["view","add","edit","Activated/Inactivated"]},{"name":"Question","key":"profillingQuestion","option":["view","add","edit","Activated/Inactivated"]},{"name":"Answer","key":"profillingAnswer","option":["view","add","edit","Activated/Inactivated"]},{"name":"Competencies","key":"profillingCompetencies","option":["view","add","edit","Activated/Inactivated"]},{"name":"Profilling","key":"profilling","option":["view","add","edit","Activated/Inactivated","template","upload"]}]},{"name":"Transaction","tab":"transaction","access_key":[{"name":"Transaction Data","key":"transaction","option":["view","revision/finalise"]},{"name":"Report","key":"report","option":["view"]}]}]}'
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
            'accKey' => 'profillingCriteria',
            'config' => '{"table":{"config":[{"data":"criteria","name":"criteria","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true},{"data":"flag","name":"flag","searchable":true,"orderable":true},{"data":"description","name":"description","searchable":true,"orderable":true}],"url":"VpCriteria","valOfField":"criteria","sortBy":["criteria","desc"]}}'
        ];
    	$store[] = [
    		'accKey' => 'profillingQuestion',
    		'config' => '{"table":{"config":[{"data":"sort","name":"sort","searchable":true,"orderable":true},{"data":"question","name":"question","searchable":true,"orderable":true},{"data":"status","name":"status","searchable":true,"orderable":true}],"url":"VpQuestion","valOfField":"question","sortBy":["criteria","desc"]}}'
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
        $store[] = [ 'accKey' => 'uarUser_upload', 'config' => 'uarUserUpload' ];
        $store[] = [ 'accKey' => 'profilling_upload', 'config' => 'profillingUpload' ];
        $store[] = [ 'accKey' => 'transaction_revision/finalise_store', 'config' => 'transactionStore' ];
        $store[] = [ 'accKey' => 'transaction_view', 'config' => 'transactionView' ];
        $store[] = [ 'accKey' => 'selfProfillingHistory_view', 'config' => 'transactionView' ];
        $store[] = [ 'accKey' => 'selfUpdate_edit_store', 'config' => 'uarUserStore' ];
        $store[] = [ 'accKey' => 'profilling_Activated/Inactivated', 'config' => 'profillingActivatedInactivated' ];
        $store[] = [ 'accKey' => 'profilling_add_store', 'config' => 'profillingStore' ];
        $store[] = [ 'accKey' => 'profilling_edit_store', 'config' => 'profillingStore' ];
        $store[] = [ 'accKey' => 'profilling_add', 'config' => 'profillingForm' ];
        $store[] = [ 'accKey' => 'profilling_view', 'config' => 'profillingForm' ];
        $store[] = [ 'accKey' => 'profillingCompetencies_Activated/Inactivated', 'config' => 'profillingCompetenciesActivatedInactivated' ];
        $store[] = [ 'accKey' => 'profillingCompetencies_add_store', 'config' => 'profillingCompetenciesStore' ];
        $store[] = [ 'accKey' => 'profillingCompetencies_edit_store', 'config' => 'profillingCompetenciesStore' ];
        $store[] = [ 'accKey' => 'profillingCompetencies_add', 'config' => 'profillingCompetenciesForm' ];
        $store[] = [ 'accKey' => 'profillingCompetencies_view', 'config' => 'profillingCompetenciesForm' ];
        $store[] = [ 'accKey' => 'profillingAnswer_Activated/Inactivated', 'config' => 'profillingAnswerActivatedInactivated' ];
        $store[] = [ 'accKey' => 'profillingAnswer_add_store', 'config' => 'profillingAnswerStore' ];
        $store[] = [ 'accKey' => 'profillingAnswer_edit_store', 'config' => 'profillingAnswerStore' ];
        $store[] = [ 'accKey' => 'profillingAnswer_add', 'config' => 'profillingAnswerForm' ];
        $store[] = [ 'accKey' => 'profillingAnswer_view', 'config' => 'profillingAnswerForm' ];
        $store[] = [ 'accKey' => 'profillingQuestion_Activated/Inactivated', 'config' => 'profillingQuestionActivatedInactivated' ];
        $store[] = [ 'accKey' => 'profillingQuestion_add_store', 'config' => 'profillingQuestionStore' ];
        $store[] = [ 'accKey' => 'profillingQuestion_edit_store', 'config' => 'profillingQuestionStore' ];
        $store[] = [ 'accKey' => 'profillingQuestion_add', 'config' => 'profillingQuestionForm' ];
        $store[] = [ 'accKey' => 'profillingQuestion_view', 'config' => 'profillingQuestionForm' ];
        $store[] = [ 'accKey' => 'profillingCriteria_Activated/Inactivated', 'config' => 'profillingCriteriaActivatedInactivated' ];
        $store[] = [ 'accKey' => 'profillingCriteria_add_store', 'config' => 'profillingCriteriaStore' ];
        $store[] = [ 'accKey' => 'profillingCriteria_edit_store', 'config' => 'profillingCriteriaStore' ];
        $store[] = [ 'accKey' => 'profillingCriteria_add', 'config' => 'profillingCriteriaForm' ];
        $store[] = [ 'accKey' => 'profillingCriteria_view', 'config' => 'profillingCriteriaForm' ];
        $store[] = [ 'accKey' => 'uarRole_Activated/Inactivated', 'config' => 'uarRoleActivatedInactivated' ];
        $store[] = [ 'accKey' => 'uarRole_add_store', 'config' => 'uarRoleStore' ];
        $store[] = [ 'accKey' => 'uarRole_edit_store', 'config' => 'uarRoleStore' ];
        $store[] = [ 'accKey' => 'uarRole_add', 'config' => 'uarRoleForm' ];
        $store[] = [ 'accKey' => 'uarRole_view', 'config' => 'uarRoleForm' ];
        $store[] = [ 'accKey' => 'uarAdmin_Activated/Inactivated', 'config' => 'uarAdminActivatedInactivated' ];
        $store[] = [ 'accKey' => 'uarAdmin_add_store', 'config' => 'uarAdminStore' ];
        $store[] = [ 'accKey' => 'uarAdmin_edit_store', 'config' => 'uarAdminStore' ];
        $store[] = [ 'accKey' => 'uarAdmin_add', 'config' => 'uarAdminForm' ];
        $store[] = [ 'accKey' => 'uarAdmin_view', 'config' => 'uarAdminForm' ];
        $store[] = [ 'accKey' => 'uarUser_Activated/Inactivated', 'config' => 'uarUserActivatedInactivated' ];
        $store[] = [ 'accKey' => 'uarUser_add_store', 'config' => 'uarUserStore' ];
        $store[] = [ 'accKey' => 'uarUser_edit_store', 'config' => 'uarUserStore' ];
        $store[] = [ 'accKey' => 'uarUser_add', 'config' => 'uarUserForm' ];
        $store[] = [ 'accKey' => 'uarUser_view', 'config' => 'uarUserForm' ];
        $store[] = [ 'accKey' => 'masterMarital_Activated/Inactivated', 'config' => 'masterActivatedInactivated' ];
        $store[] = [ 'accKey' => 'masterReligion_Activated/Inactivated', 'config' => 'masterActivatedInactivated' ];
        $store[] = [ 'accKey' => 'masterIndustry_Activated/Inactivated', 'config' => 'masterActivatedInactivated' ];
        $store[] = [ 'accKey' => 'masterLevel_Activated/Inactivated', 'config' => 'masterActivatedInactivated' ];
        $store[] = [ 'accKey' => 'masterEducation_Activated/Inactivated', 'config' => 'masterActivatedInactivated' ];
        $store[] = [ 'accKey' => 'masterCompetencies_Activated/Inactivated', 'config' => 'masterActivatedInactivated' ];
        $store[] = [ 'accKey' => 'masterMarital_add_store', 'config' => 'masterStore' ];
        $store[] = [ 'accKey' => 'masterReligion_add_store', 'config' => 'masterStore' ];
        $store[] = [ 'accKey' => 'masterIndustry_add_store', 'config' => 'masterStore' ];
        $store[] = [ 'accKey' => 'masterLevel_add_store', 'config' => 'masterStore' ];
        $store[] = [ 'accKey' => 'masterEducation_add_store', 'config' => 'masterStore' ];
        $store[] = [ 'accKey' => 'masterCompetencies_add_store', 'config' => 'masterStore' ];
        $store[] = [ 'accKey' => 'masterMarital_edit_store', 'config' => 'masterStore' ];
        $store[] = [ 'accKey' => 'masterReligion_edit_store', 'config' => 'masterStore' ];
        $store[] = [ 'accKey' => 'masterIndustry_edit_store', 'config' => 'masterStore' ];
        $store[] = [ 'accKey' => 'masterLevel_edit_store', 'config' => 'masterStore' ];
        $store[] = [ 'accKey' => 'masterEducation_edit_store', 'config' => 'masterStore' ];
        $store[] = [ 'accKey' => 'masterCompetencies_edit_store', 'config' => 'masterStore' ];
        $store[] = [ 'accKey' => 'masterMarital_add', 'config' => 'masterForm' ];
        $store[] = [ 'accKey' => 'masterReligion_add', 'config' => 'masterForm' ];
        $store[] = [ 'accKey' => 'masterIndustry_add', 'config' => 'masterForm' ];
        $store[] = [ 'accKey' => 'masterLevel_add', 'config' => 'masterForm' ];
        $store[] = [ 'accKey' => 'masterEducation_add', 'config' => 'masterForm' ];
        $store[] = [ 'accKey' => 'masterCompetencies_add', 'config' => 'masterForm' ];
        $store[] = [ 'accKey' => 'masterMarital_view', 'config' => 'masterForm' ];
        $store[] = [ 'accKey' => 'masterReligion_view', 'config' => 'masterForm' ];
        $store[] = [ 'accKey' => 'masterIndustry_view', 'config' => 'masterForm' ];
        $store[] = [ 'accKey' => 'masterLevel_view', 'config' => 'masterForm' ];
        $store[] = [ 'accKey' => 'masterEducation_view', 'config' => 'masterForm' ];
        $store[] = [ 'accKey' => 'masterCompetencies_view', 'config' => 'masterForm' ];
        foreach ($store as $row) {
            $store = new Config;
            $store->accKey = $row['accKey'];
            $store->config = $row['config'];
            $store->save();
        }
    }
}
