<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramAuth;

// $username = 'riedayme';
// $password = 'igxrealig223366';

$username = 'username';
$password = 'password';

$auth = new InstagramAuth();

$results = $auth->AuthLoginByAPI($username,$password);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(7) {
  ["userid"]=>
  int(31310607724)
  ["username"]=>
  string(8) "riedayme"
  ["photo"]=>
  string(273) "https://instagram.fupg5-1.fna.fbcdn.net/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=instagram.fupg5-1.fna.fbcdn.net&_nc_cat=1&_nc_ohc=ZMRBdU8i2AoAX_IErC2&oh=09a49dcd7d53d2c9b4edf1cb4f9df5bb&oe=5F13AC8F&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2"
  ["cookie"]=>
  string(168) "ds_user=riedayme;csrftoken=vmESyfwhD29RHnpSmf5IpbLIz7MZXkdp;rur=VLL;mid=XuuCZwABAAHWql7NpTNNMz_8LD_P;ds_user_id=31310607724;sessionid=31310607724%3ARbatF6IHrMBxf1%3A19;"
  ["csrftoken"]=>
  string(32) "vmESyfwhD29RHnpSmf5IpbLIz7MZXkdp"
  ["rank_token"]=>
  string(48) "31310607724_d4295d87-0db1-4c83-bb99-3d9aee0f719b"
  ["useragent"]=>
  string(94) "Instagram 9.6.0 Android (19/4.4.2; 480dpi; 1080x1920; samsung; SM-N900T; hltetmo; qcom; en_US)"
}
*/