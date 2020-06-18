<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramAuth;

$username = 'username';
$password = 'password';

$auth = new InstagramAuth();

$results = $auth->AuthLoginByWebAjax($username,$password);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(5) {
  ["userid"]=>
  string(11) "31310607724"
  ["username"]=>
  string(8) "riedayme"
  ["photo"]=>
  string(265) "https://scontent-sjc3-1.cdninstagram.com/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=scontent-sjc3-1.cdninstagram.com&_nc_ohc=ZMRBdU8i2AoAX8JQNfr&oh=fe20d45b815d51701b351e629c71945e&oe=5F13AC8F&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2"
  ["cookie"]=>
  string(187) "target="";target="";target="";target="";target="";target="";target="";csrftoken=C1HA2mbeiU08vwRb0eq4RYk6pRuFI4kn;rur=VLL;ds_user_id=31310607724;sessionid=31310607724%3AeiJLueiji9NpFA%3A0;"
  ["csrftoken"]=>
  string(32) "C1HA2mbeiU08vwRb0eq4RYk6pRuFI4kn"
}
*/