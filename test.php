<?php  
function get_limit($delay){
	$cron = 5;
	$dayinminutes = 1440;
	$total_cron_in_one_day = $dayinminutes/$cron;
	$process = $delay;
	$per_cron_process = $process/$total_cron_in_one_day;
	$limit = ceil($per_cron_process);
	return $limit;
}

function get_sleep_time_by_limit($limit){

	$dayinseconds = 86400;

	$sleep = $dayinseconds/$limit;

	return ceil($sleep);
}

$limit_process = get_sleep_time_by_limit(80);
// echo $limit_process;
// exit;
$time_quesiton = false;
$datastory = ['question','pool','pool','question','pool'];

while (true) {
	foreach ($datastory as $story) {
		if ($story == 'question') {

			if ($time_quesiton AND strtotime(date('Y-m-d H:i:s')) <= strtotime($time_quesiton)) {
				echo "skip question next process time {$time_quesiton}".PHP_EOL;
				continue;
			}
			$time_quesiton = date('Y-m-d H:i:s',strtotime("+{$limit_process} seconds"));
		}

		echo $story.PHP_EOL;
		// echo date('Y-m-d H:i:s').PHP_EOL;
		sleep(1);
	}
}

/**
 * jika waktu saat ini sudah melewati next time process  
 * maka bisa proses lagi > set next time again
 * jika belum maka diskip lanjut ke story selanjutnya 
 
	
ex :
loop
	vote story 1 > answer question > if answer question set next time process question time
	vote story 2 > answer pool > process
	vote story 3 > answer question > check if this time >= next time process ? process : skip
	vote story 3 > answer slider > process
	...
	... 
 */