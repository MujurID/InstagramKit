<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramDirectCreateAPI;
use Riedayme\InstagramKit\InstagramDirectBroadcastAPI;

$datacookie = 'yourcookie';

$userids = ['13320596140']; // faanteyki

$message = 'test messsage';

$directcreate = new InstagramDirectCreateAPI();
$directcreate->SetCookie($datacookie);
$get_thread_id = $directcreate->Process($userids);
$thread_ids = [$get_thread_id['response']['thread_id']];

$directcreate = new InstagramDirectBroadcastAPI();
$directcreate->SetCookie($datacookie);
$results = $directcreate->Process($message,$thread_ids);


echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(2) {
  ["status"]=>
  bool(true)
  ["response"]=>
  array(1) {
    ["thread_id"]=>
    string(39) "340282366841710300949128295959165536416"
  }
}
*/