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
    		'status' => 'Y',
    		'roll_id' => 1,
    		'password' => 'try.you'
    	];
        $store = new User;
        $store->name = $store['name'];
        $store->email = $store['email'];
        $store->status = $store['status'];
        $store->roll_id = $store['roll_id'];
        $store->password = $store['password'];
        $store->save();
    }
}
