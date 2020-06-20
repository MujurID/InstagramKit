<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramFeedStoryAPI;
use Riedayme\InstagramKit\InstagramSeenStoryAPI;

$datacookie = 'csrftoken=qMtxFlqJKM7O3xDSNVzJE0w6kYaGEja1;rur=ASH;ds_user_id=31310607724;sessionid=31310607724%3AUJbi6M63uI2Kcb%3A20;';

$useridtarget = '13320596140';

$readstory = new InstagramFeedStoryAPI();
$readstory->SetCookie($datacookie);
$StoryUser = $readstory->GetStoryUser($useridtarget);

// echo json_encode($StoryUser);
// exit;

$seenstory = new InstagramSeenStoryAPI();
$seenstory->SetCookie($datacookie);
$seenstory->SetOption([
  'story_questions' => [
    'active' => true,
    'message' => 'wih mantap bosqu~'
  ],
  'story_polls' => [
    'active' => true,
    'vote' => rand(0,1)
  ],
  'story_countdowns' => [
    'active' => true
  ],
  'story_sliders' => [
    'active' => true,
    'vote' => '1'
  ],
  'story_quizs' => [
    'active' => true
  ],
]);

foreach ($StoryUser as $story) {

  $results = $seenstory->SeenStoryByAPI($story);
  echo "<pre>";
  var_dump($results);
  echo "</pre>";
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