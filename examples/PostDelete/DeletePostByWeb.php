<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramPostDelete;

$datacookie = 'yourcookie';

$postid= 'postid';

$deletepost = new InstagramPostDelete();
$deletepost->SetCookie($datacookie);

$results = $deletepost->Process($postid);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(2) {
  ["success"]=>
  int(1)
  ["failed"]=>
  int(0)
}
*/