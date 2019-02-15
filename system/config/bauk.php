<?php return[
	'lock_day'=> 4,
	'work_hours'=>[
		'max_arrival'=>\Carbon\Carbon::createFromFormat('H:i:s', '06:50:00'),
		'min_departure'=>\Carbon\Carbon::createFromFormat('H:i:s', '15:45:00'),
	]
];