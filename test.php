<?php  

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