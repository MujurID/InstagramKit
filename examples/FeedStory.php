<?php  
require "../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramFeedStory;

$datacookie = 'yourcookie';

$process = new InstagramFeedStory();
$process->Auth($datacookie,'cookie');

$StoryList = $process->GetStoryList();
$StoryUser = $process->GetStoryUser($StoryList);

echo "<pre>";
var_dump($StoryUser);
echo "</pre>";