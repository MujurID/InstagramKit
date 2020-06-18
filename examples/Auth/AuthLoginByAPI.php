<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramAuth;

$username = 'riedayme';
$password = 'igxrealig223366';

$auth = new InstagramAuth();

$results = $auth->AuthLoginByAPI($username,$password);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(6) {
  ["userid"]=>
  int(31310607724)
  ["username"]=>
  string(8) "riedayme"
  ["photo"]=>
  string(275) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=1&_nc_ohc=ZMRBdU8i2AoAX_9sjIo&oh=3c5440bf24142156488d53209c369e95&oe=5F13AC8F&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2"
  ["cookie"]=>
  string(167) "ds_user=riedayme;csrftoken=8hRXfkii8DTkatrwf7A1QhjypwTBqTuq;rur=VLL;mid=XutfUQABAAEWtSdGnP72bNfrQ5uy;ds_user_id=31310607724;sessionid=31310607724%3AKWfh15Z5qspaGr%3A5;"
  ["csrftoken"]=>
  string(32) "8hRXfkii8DTkatrwf7A1QhjypwTBqTuq"
  ["rank_token"]=>
  string(48) "31310607724_75744ff5-2edc-488f-8608-2edec2b5c2af"
}
*/