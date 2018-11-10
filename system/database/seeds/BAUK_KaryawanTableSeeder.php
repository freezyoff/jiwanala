<?php

use Illuminate\Database\Seeder;

class BAUK_KaryawanTableSeeder extends Seeder
{
	protected $fillable = [
		'NIP',
		'KTP',
		'nama_gelar_depan',
		'nama_lengkap',
		'nama_gelar_belakang',
		'alamat',
		'rt',
		'rw',
		'kelurahan',
		'kecamatan',
		'kota',
		'provinsi',
		'kode_pos',
		'tlp1',
		'tlp2',
		'status_pernikahan',
		'tanggal_masuk',
	];
	
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$loop = 0; $max = rand(9,999);
		while($loop<$max){
			$model = \App\DBModels\JNBauk\Karyawan::create($this->generateData());
			$model->save();
			$loop++;
		}
    }
	
	function generateRandomString($length = 10) {
		$x='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr( str_shuffle( str_repeat($x,ceil($length/strlen($x)) ) ),1 ,$length);
	}
	
	function generateRandomNumber($length = 10){
		$rand = "0123456789";
		return substr( str_shuffle( str_repeat($rand,ceil($length/strlen($rand)) ) ),1 ,$length);
	}
	
	public function generateData(){
		$faker = Faker\Factory::create();
		$statusNikah = ['bm', 'mn', 'cr', 'mt'];
		return [
			'NIP' => $this->generateRandomNumber(rand(10,20)),
			'KTP'=> $this->generateRandomNumber(rand(10,25)),
			'nama_gelar_depan' => $faker->title() ,//$this->generateRandomString(rand(10,50)),
			'nama_lengkap' => $faker->firstName(),//$this->generateRandomString(rand(10,100)),
			'nama_gelar_belakang' => $faker->lastName(), //$this->generateRandomString(rand(10,50)),
			'alamat' => $faker->streetAddress(), //$this->generateRandomString(rand(50,200)),
			'rt' => $this->generateRandomNumber(rand(1,3)),
			'rw' => $this->generateRandomNumber(rand(1,3)),
			'kelurahan' => $faker->state(), //$this->generateRandomString(rand(10,50)),
			'kecamatan' => $faker->state(), //$this->generateRandomString(rand(10,50)),
			'kota' => $faker->city(), //$this->generateRandomString(rand(10,50)),
			'provinsi' => $faker->state(), //$this->generateRandomString(rand(10,50)),
			'kode_pos' => str_replace("-","",$faker->postcode()), //$this->generateRandomNumber(rand(1,20)),
			'tlp1' => str_replace("-","",$faker->phoneNumber()), //$this->generateRandomNumber(rand(10,20)),
			'tlp2' => str_replace("-","",$faker->phoneNumber()), //$this->generateRandomNumber(rand(10,20)),
			'status_pernikahan' => $statusNikah[rand(0,count($statusNikah)-1)],
			'tanggal_masuk' => date("Y-m-d", time()),
		];
	}
}
