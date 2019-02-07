<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableEmployeeConsentAttachments extends Migration
{
    protected $connection = 'bauk';
	protected $tables = [
		'user'=>'users',
		'employee-attendance'=>'employee_attendance',
		'employee-consent-attachments'=>'employee_consent_attachments'
	];
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createSchema(function (Blueprint $table) {
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('ref table service.users');
			$table->increments('id');
			$table->integer('employee_consent_id')->unsigned()->comment('id on bauk.employee_attendance');
			$table->binary('attachment');
			$table->integer('size')->default(0)->comment('besar file');
			$table->string('ext',4)->default('')->comment('ekstensi file');
			$table->string('mime',100)->default('')->comment('mime file');
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('employee_consent_id')->references('id')
				->on($this->getSchemaName('bauk').'.'.$this->getTableName('employee-attendance'));
		}, 'employee-consent-attachments');
		
		DB::connection($this->connection)->statement("ALTER TABLE `employee_consent_attachments` MODIFY `attachment` MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        $this->dropSchema('employee-consent-attachments');
    }
}
