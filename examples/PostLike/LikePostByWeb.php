<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramPostLike;

$datacookie = 'yourcookie';

$postid = '2332344911195799233';

$likepost = new InstagramPostLike();
$likepost->SetCookie($datacookie);

$results = $likepost->Process($postid);

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