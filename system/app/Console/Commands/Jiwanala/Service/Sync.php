<?php

namespace App\Console\Commands\Jiwanala\Service;

use Illuminate\Console\Command;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-service:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync predefined service records';

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
        $this->call('jn-permission');
    }
}
