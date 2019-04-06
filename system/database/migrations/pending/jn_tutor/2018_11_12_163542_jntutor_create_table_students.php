<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JntutorCreateTableStudents extends Migration
{
	protected $connection = 'jn_tutor';
	protected $table = "students";
	
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
            $table->char('token_key',255)->unique()->comment('Token signin');
            $table->timestamp('token_expired')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Tanggal expired token');
			$table->string('username', 100)->unique();
			$table->char('password', 255);
            $table->string('NIS',20)->unique()->comment('Nomor Index Siswa Bimbel');
            $table->string('phone',20)->unique()->comment('Nomor telepon Siswa Bimbel');
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
