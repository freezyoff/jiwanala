<?php

namespace App\Console\Commands\Bauk;

use Illuminate\Console\Command;

class JiwanalaEmployeeAttendance_Lock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiwanala:employee-attendance-lock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lock employee attendance records';

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
		$now = now();
		$records = \App\Libraries\Bauk\EmployeeAttendance::where(function($q) use($now){
			$q->whereRaw('MONTH(`date`) < '.$now->format('n'));
			$q->whereRaw('YEAR(`date`) = '.$now->format('Y'));
		})->orWhere(function($q) use($now){
			$q->whereRaw('YEAR(`date`) <> '.$now->format('Y'));
		});
        foreach($records->get() as $rec){
			$this->info('Get -> id: '.$rec->id.' date: '.$rec->date. ' locked: '.$rec->locked);
			if (!$rec->locked){
				$rec->locked = true;
				$rec->save();
				$this->info('Save -> id:'.$rec->id.' date: '.$rec->date. ' locked: '.$rec->locked);
			}
		}
    }
}
