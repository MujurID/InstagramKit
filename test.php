<?php  
date_default_timezone_set('Asia/Jakarta');

$begin_ms = strtotime(date("Y-m-d H:i:s") ."-2 minutes");

$delay = 20;
$now_ms = strtotime( date( 'Y-m-d H:i:s' ) );
$counter3 = $delay - ( $now_ms - $begin_ms );

echo 0 % 1000;

exit;
do {
	echo $counter3;
	sleep( 1 );
	$counter3 -= 1;
} while ( $counter3 != 0 );

exit;
$speed = 400000;
echo round( 60 * 60 * 24 * 10 / $speed );
exit;

function progress_bar($done, $total, $info="", $width=50) {
	$perc = round(($done * 100) / $total);
	$bar = round(($width * $perc) / 100);
	return sprintf("%s%%[%s>%s]%s\r", $perc, str_repeat("=", $bar), str_repeat(" ", $width-$bar), $info);
}

$tasks = 200;
$done = 0;
for($done = 0; $done <= $tasks; $done++){
	usleep((rand() % 127)*100);

	echo progress_bar($done, $tasks);
}

echo "ayee";

?>