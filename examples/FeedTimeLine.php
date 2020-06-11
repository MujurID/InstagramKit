<?php  
require "../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramFeedTimeLine;

$datacookie = 'yourcookie';

$process = new InstagramFeedTimeLine();
$process->Auth($datacookie,'cookie');

$results = $process->GetFeedTimeLine([
	'type' => 'scraping',
	'deep' => 1
]);

echo "<pre>";
var_dump($results);
echo "</pre>";