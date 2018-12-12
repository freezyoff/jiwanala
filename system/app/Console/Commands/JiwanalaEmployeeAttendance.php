<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Libraries\Bauk\EmployeeAttendanceImport;
use \App\Libraries\Bauk\EmployeeAttendance;

class JiwanalaEmployeeAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiwanala:employee-attendance {cmd}
								{--F|file= : Absolute File path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import employee attendance data from csv file format and save given data to database bauk.employee_attendance';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('cmd') == 'import'){
			$import = (new EmployeeAttendance)->toArray('employee_attendance.csv', 'local');
		}
    }
}
