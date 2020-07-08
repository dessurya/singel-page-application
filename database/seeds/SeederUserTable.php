<?php

use Illuminate\Database\Seeder;
use App\Model\User;

class SeederUserTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $store = new User;
        $store->name = 'administrator';
        $store->email = 'your.administrator@try.you';
        $store->status = 'Y';
        $store->roll_id = 1;
        $store->password = 'try.you';
        $store->save();

        $store = new User;
        $store->name = 'Adam';
        $store->email = 'fourline66@gmail.com';
        $store->status = 'Y';
        $store->roll_id = 1;
        $store->password = 'asdasd';
        $store->save();
    }
}
