<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployeeConsentAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("employee_consent_attachments", function (Blueprint $table) {
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('ref table service.users');
			$table->increments('id');
			$table->integer('employee_consent_id')->unsigned()->comment('id on bauk.employee_attendance');
			$table->binary('attachment');
			$table->integer('size')->default(0)->comment('besar file');
			$table->string('ext',4)->default('')->comment('ekstensi file');
			$table->string('mime',100)->default('')->comment('mime file');
			
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
			$table->foreign('employee_consent_id')->references('id')->on('employee_attendance');
		});
		
		DB::statement("ALTER TABLE `employee_consent_attachments` MODIFY `attachment` MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('employee_consent_attachments');
    }
}
