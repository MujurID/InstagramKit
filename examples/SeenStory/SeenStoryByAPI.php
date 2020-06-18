<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramFeedStory;
use Riedayme\InstagramKit\InstagramSeenStory;

$datacookie = 'ds_user=riedayme;csrftoken=vmESyfwhD29RHnpSmf5IpbLIz7MZXkdp;rur=VLL;mid=XuuCZwABAAHWql7NpTNNMz_8LD_P;ds_user_id=31310607724;sessionid=31310607724%3ARbatF6IHrMBxf1%3A19;';

$useragent = 'Instagram 9.6.0 Android (19/4.4.2; 480dpi; 1080x1920; samsung; SM-N900T; hltetmo; qcom; en_US)';

$uuid = 'd4295d87-0db1-4c83-bb99-3d9aee0f719b';

$token = '31310607724_d4295d87-0db1-4c83-bb99-3d9aee0f719b';

$userid = '13320596140';

$process = new InstagramFeedStory();
$process->SetCookie($datacookie);
$process->SetUserAgent($useragent);
// $StoryUser = $process->GetFeedStoryUserByAPI($userid);
$StoryList = $process->GetStoryList();
$StoryUser = $process->GetStoryUser($StoryList);

$seenstory = new InstagramSeenStory();
$seenstory->SetCookie($datacookie);
$seenstory->SetUserAgent($useragent);
$seenstory->SetUUID($uuid);
$seenstory->SetUID($userid);
$seenstory->SetToken($token);

foreach ($StoryUser as $story) {
	$results = $seenstory->SeenStoryByAPI($story);
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