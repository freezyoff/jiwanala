<?php

use Illuminate\Database\Seeder;

class JNCore_Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userModel = new \App\DBModels\JNCore\UserModel;
		$userModel->name = 'akhmad.musa.hadi';
		$userModel->email = 'akhmad.musa.hadi@gmail.com';
		$userModel->password = Hash::make('yousummonme3105');
        $userModel->save();
    }
}
