<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramPostComment;

$datacookie = 'yourcookie';

$postid = '2332344911195799233'; // riedayme post
$message = 'test comment';

$likecomment = new InstagramPostComment();
$likecomment->SetCookie($datacookie);

$results = $likecomment->Process($postid,$message);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(2) {
  ["status"]=>
  bool(true)
  ["response"]=>
  string(69) "success send comment to post 2332344911195799233 message test comment"
}
*/