#!/usr/bin/env php
<?php
define('LARAVEL_START', microtime(true));

$marker = date('Y-m-d H:i:s');

require __DIR__.'/../../../../system/vendor/autoload.php';

$app = require_once __DIR__.'/../../../../system/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();


//make \Illuminate\Queue\QueueManager::class
$databaseQueue = app('queue'); 							//get DatabaseQueue instance
$currentQueue = $databaseQueue->getQueue(null);			//get Queue group
$maxCounter = $databaseQueue->size();
$counter=0;
echo $marker.' Job count: '.$maxCounter.PHP_EOL;
while($counter<$maxCounter){
	$databaseJob = $databaseQueue->pop($currentQueue); 	//get the DatabaseJob
	if (!is_null($databaseJob)){
		echo $marker.' Fire Job: '.($counter+1).PHP_EOL;
		$databaseJob->fire();							//fire it !!!!!!!
	}
	$counter++;
}