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
	$results = $seenstory->Process($story);
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
  string(19) "2334537192093194524"
  ["username"]=>
  string(9) "faanteyki"
}
*/