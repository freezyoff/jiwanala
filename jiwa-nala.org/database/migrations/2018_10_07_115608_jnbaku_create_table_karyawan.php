<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JnbakuCreateTableKaryawan extends Migration
{
	protected $connection = 'jn_bauk';
	protected $table = "karyawan";
	
	protected function schema(){
		return Schema::connection($this->connection);
	}
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema()->create($this->table, function (Blueprint $table) {
            $table->timestamps();
			$table->increments('id');
            $table->string('NIP',20)->unique()->comment('Nomor Index Pegawai/Karyawan');
            $table->string('KTP',25);
            $table->string('nama_gelar_depan', 50)->nullable();
            $table->string('nama_lengkap', 100);
            $table->string('nama_gelar_belakang', 50)->nullable();
            $table->string('alamat', 200);
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('kelurahan', 50);
            $table->string('kecamatan', 50);
            $table->string('kota', 50);
            $table->string('provinsi', 50);
            $table->string('kode_pos', 20);
            $table->string('tlp1', 20);
            $table->string('tlp2', 20)->nullable();
            $table->enum('status_pernikahan',['bm','mn','cr','mt'])->comment('bm: belum menikah, mn:menikah, dj: duda/janda cerai, mt: duda/janda mati');
            $table->timestamp('tanggal_masuk')->nullable();
            $table->timestamp('tanggal_keluar')->nullable();
            $table->boolean('aktif')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema()->dropIfExists($this->table);
    }
}
