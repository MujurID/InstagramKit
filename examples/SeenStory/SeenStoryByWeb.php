<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramFeedStory;
use Riedayme\InstagramKit\InstagramSeenStory;

$datacookie = 'yourcookie';

$process = new InstagramFeedStory();
$process->SetCookie($datacookie);
// $StoryList = $process->GetStoryList();
$StoryList[] = ['id' => '13320596140'];
$StoryUser = $process->GetStoryUser($StoryList);

$seenstory = new InstagramSeenStory();
$seenstory->SetCookie($datacookie);

foreach ($StoryUser as $story) {
	$results = $seenstory->SeenStoryByWeb($story);
	echo "<pre>";
	var_dump($results);
	echo "</pre>";
	exit;
}

/*
array(3) {
  ["status"]=>
  bool(true)
  ["id"]=>
  string(19) "2334166284923520094"
  ["username"]=>
  string(12) "fauzan121002"
}
*/