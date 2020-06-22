<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramPostCommentLike;

$datacookie = 'yourcookie';

$commentid = '17857683010999361';

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
  ["id"]=>
  string(19) "2332344911195799233"
}
*/