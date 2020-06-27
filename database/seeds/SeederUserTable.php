<?php

use Illuminate\Database\Seeder;
use App\Model\User;
use Hash;

class SeederUserTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
    	$store = [
    		'name' => 'administrator',
    		'email' => 'your.administrator@try.you',
    		'statu' => 'Y',
    		'roll_id' => 1,
    		'password' => Hash::make('try.you')
    	];
    	Role::create($store);
    }
}
