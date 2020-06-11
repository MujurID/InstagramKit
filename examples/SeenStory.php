<?php  
require "../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramFeedStory;
use Riedayme\InstagramKit\InstagramSeenStory;

$datacookie = 'yourcookie';

$process = new InstagramFeedStory();
$process->Auth($datacookie,'cookie');

$StoryList = $process->GetStoryList();
$StoryUser = $process->GetStoryUser($StoryList);

$seenstory = new InstagramSeenStory();
$seenstory->Auth($datacookie,'cookie');

foreach ($StoryUser as $story) {
	$results = $seenstory->SeenStoryByWeb($story);
	echo "<pre>";
	var_dump($results);
	echo "</pre>";
	exit;
}
