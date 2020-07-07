<?php

use Illuminate\Database\Seeder;
use App\Model\Role;

class SeederRoleTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
    	$store = [];
    	$store[] = [
    		'status' => 'Y',
    		'name' => 'master',
    		'access_menu' => '{"menu":[{"name":"User/AdminAccess","tab":"uar","chld":[{"name":"UserData","accKey":"uarUser"},{"name":"AdminData","accKey":"uarAdmin"},{"name":"RoleData","accKey":"uarRole"}]},{"name":"MasterData","tab":"master","chld":[{"name":"Marital","accKey":"masterMarital"},{"name":"Religion","accKey":"masterReligion"},{"name":"Industry","accKey":"masterIndustry"},{"name":"Level","accKey":"masterLevel"},{"name":"Education","accKey":"masterEducation"},{"name":"Competencies","accKey":"masterCompetencies"}]},{"name":"ProfillingData","tab":"profilling","chld":[{"name":"Question","accKey":"profillingQuestion"},{"name":"Answer","accKey":"profillingAnswer"},{"name":"Competencies","accKey":"profillingCompetencies"},{"name":"Profilling","accKey":"profilling"}]},{"name":"Transaction","tab":"transaction","chld":[{"name":"TransactionData","accKey":"transaction"},{"name":"Report","accKey":"report"}]}],"accKey":{"uarUser":{"template":true,"upload":true,"Activated/Inactivated":true,"view":true,"add":true,"edit":true},"uarAdmin":{"Activated/Inactivated":true,"view":true,"add":true,"edit":true},"uarRole":{"Activated/Inactivated":true,"view":true,"add":true,"edit":true},"masterMarital":{"Activated/Inactivated":true,"view":true,"add":true,"edit":true},"masterReligion":{"Activated/Inactivated":true,"view":true,"add":true,"edit":true},"masterIndustry":{"Activated/Inactivated":true,"view":true,"add":true,"edit":true},"masterLevel":{"Activated/Inactivated":true,"view":true,"add":true,"edit":true},"masterEducation":{"Activated/Inactivated":true,"view":true,"add":true,"edit":true},"masterCompetencies":{"Activated/Inactivated":true,"view":true,"add":true,"edit":true},"profillingQuestion":{"Activated/Inactivated":true,"view":true,"add":true,"edit":true},"profillingAnswer":{"Activated/Inactivated":true,"view":true,"add":true,"edit":true},"profillingCompetencies":{"Activated/Inactivated":true,"view":true,"add":true,"edit":true},"profilling":{	"template":true,"upload":true,"Activated/Inactivated":true,"view":true,"add":true,"edit":true},"transaction":{"view":true,"revision/finalise":true}}}'
    	];
    	$store[] = [
    		'status' => 'Y',
    		'name' => 'public',
    		'access_menu' => '{"menu":[{"name":"MainMenu","tab":"mm","chld":[{"name":"UpdatePersonal","accKey":"selfUpdate"},{"name":"ViewProfilling","accKey":"selfProfillingHistory"},{"name":"TakeProfilling","accKey":"takeProfilling"}]}],"accKey":{"selfUpdate":{"view":true,"edit":true},"selfProfillingHistory":{"view":true},"takeProfilling":{"store":true}}}'
    	];
        foreach ($store as $row) {
            $store = new Role;
            $store->status = $row['status'];
            $store->name = $row['name'];
            $store->access_menu = $row['access_menu'];
            $store->save();
        }
    }
}