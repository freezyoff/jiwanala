<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class JNBimbel_StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new App\DBModels\JNBimbel\Student;
		$model->updateToken();
		$model->NIS = '123456789';
		$model->username = 'akhmad.musa.hadi';
		$model->password = Hash::make('akhmad.musa.hadi');
		$model->phone = '+628113209855';
        $model->save();
    }
}
