<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramPostCommentLike;

$datacookie = 'csrftoken=774rNGrfgv6ar6CinLorwvzAOXKGAy5F;rur=ASH;ds_user_id=31310607724;urlgen=\"{\\\"180.244.234.177\\\": 7713}:1jmq6F:Ebmk4cYBCu3rpLqHxJNA4uFCBUI\";sessionid=31310607724%3AD3BnzqxHNaIDKz%3A22;';

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