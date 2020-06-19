<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramChecker;

$cookie = 'yourcookie';

$check = new InstagramChecker();
$results =$check->CheckLiveCookie($cookie);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(3) {
  ["userid"]=>
  string(11) "31310607724"
  ["username"]=>
  string(8) "riedayme"
  ["photo"]=>
  string(265) "https://scontent-lax3-1.cdninstagram.com/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=scontent-lax3-1.cdninstagram.com&_nc_ohc=CgRv3KotZXUAX8VJKNP&oh=d23302a4c620270de3f99284c532bd2e&oe=5F13AC8F&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2"
}
*/