<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramPostLikeAPI;

$datacookie = 'yourcookie';

$postid = '2332344911195799233';

$likepost = new InstagramPostLikeAPI();
$likepost->SetCookie($datacookie);

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