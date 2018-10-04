<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$userModel = new \App\Models\UserModel;
		$userModel->name = 'akhmad.musa.hadi';
		$userModel->email = 'akhmad.musa.hadi@gmail.com';
		$userModel->password = bcrypt('yousummonme3105');
        $userModel->save();
		
		$loop = 0;
		while($loop<5){
			$range 				= md5(microtime());
			$dummies			= new \App\Models\UserModel;
			$dummies->name		= $range;
			$dummies->email		= $range.'@domain.com';
			$dummies->password	= bcrypt($range);
			$dummies->activated	= round(mt_rand(0,1));
			$dummies->save();
			$loop++;
		}
    }
}