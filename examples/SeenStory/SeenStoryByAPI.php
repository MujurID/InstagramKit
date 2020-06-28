<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramFeedStoryAPI;
use Riedayme\InstagramKit\InstagramSeenStoryAPI;

$datacookie = 'yourcookie';

$user_ids = ['13320596140'];

$readstory = new InstagramFeedStoryAPI();
$readstory->SetCookie($datacookie);
$datastory = $readstory->GetStoryUser($user_ids);
$StoryUser = $readstory->ExtractStoryUser($datastory);

// echo json_encode($StoryUser);
// exit;

$seenstory = new InstagramSeenStoryAPI();
$seenstory->SetCookie($datacookie);

/* mass seen story */
// $BuildSeenStory = $seenstory->BuildSeenStory($StoryUser);
// $results = $seenstory->Process($BuildSeenStory);

// echo "<pre>";
// var_dump($results);
// echo "</pre>";

/*
array(2) {
  ["status"]=>
  bool(true)
  ["response"]=>
  string(20) "success seen 3 story"
}
*/

/* vote story */
$process_vote = array();
if (array_key_exists('status', $StoryUser)) die($StoryUser['response']);
foreach ($StoryUser as $storydata) {
  if ($storydata['story_detail']['type'] == 'questions') 
  {
    $answer = 'test answer';
    $process_vote[] = $seenstory->AnswerQuestions($storydata,$answer);
  }
  elseif ($storydata['story_detail']['type'] == 'polls') 
  {
    $process_vote[] = $seenstory->VotePolls($storydata,'1');
  }
  elseif ($storydata['story_detail']['type'] == 'countdowns') 
  {
    $process_vote[] = $seenstory->FollowCountdowns($storydata);
  }
  elseif ($storydata['story_detail']['type'] == 'sliders') 
  {
    $min = 10; 
    $max = 200;
    $point = ( mt_rand( $min, $max ) / 100 );
    $point = ($point > 1 ? 1 : $point);
    $process_vote[] = $seenstory->VoteSliders($storydata,$point);
  }
  elseif ($storydata['story_detail']['type'] == 'quizs') 
  {
    $process_vote[] = $seenstory->AnswerQuizs($storydata);
  }
}

echo "<pre>";
var_dump($process_vote);
echo "</pre>";

/*
array(2) {
  ["status"]=>
  bool(true)
  ["response"]=>
  string(20) "success seen 3 story"
}
*/