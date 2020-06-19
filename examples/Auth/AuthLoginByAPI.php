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
array(8) {
  ["userid"]=>
  int(31310607724)
  ["username"]=>
  string(8) "riedayme"
  ["photo"]=>
  string(275) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=1&_nc_ohc=CgRv3KotZXUAX8WqwX-&oh=b50a2fcf9985c1f6517c7314d385c9b8&oe=5F13AC8F&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2"
  ["cookie"]=>
  string(167) "ds_user=riedayme;csrftoken=2dBSVPfzJ7iDY7WsreeyWqQwNeWWliyi;rur=VLL;mid=XuwYDwABAAFW7t2Q9ONi5pDwu93i;ds_user_id=31310607724;sessionid=31310607724%3AG9FtED5onws52m%3A8;"
  ["csrftoken"]=>
  string(32) "2dBSVPfzJ7iDY7WsreeyWqQwNeWWliyi"
  ["uuid"]=>
  string(36) "694b0dcd-dc7c-4a57-a36b-21448804ea9c"
  ["rank_token"]=>
  string(48) "31310607724_694b0dcd-dc7c-4a57-a36b-21448804ea9c"
  ["useragent"]=>
  string(94) "Instagram 9.6.0 Android (19/4.4.2; 480dpi; 1080x1920; samsung; SM-N900T; hltetmo; qcom; en_US)"
}
*/