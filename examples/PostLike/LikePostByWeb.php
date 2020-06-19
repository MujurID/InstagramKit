<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramPostLike;

$datacookie = 'yourcookie';

$postid = '2332344911195799233';

$likepost = new InstagramPostLike();
$likepost->SetCookie($datacookie);
$likepost->SetCSRF($datacookie);

$results = $likepost->Process([
	'id' => $postid
	]);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(2) {
  ["status"]=>
  bool(true)
  ["id"]=>
  string(19) "2332344911195799233"
}
*/