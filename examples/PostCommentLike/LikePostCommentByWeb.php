<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramPostCommentLike;

$datacookie = 'yourcookie';

$commentid = '17893046791541968'; // riedayme post > comment : hehe

$likecomment = new InstagramPostCommentLike();
$likecomment->SetCookie($datacookie);

$results = $likecomment->Process($commentid);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(2) {
  ["status"]=>
  bool(true)
  ["response"]=>
  string(38) "success like comment 17893046791541968"
}
*/