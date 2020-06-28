<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramUserUnFollow;

$datacookie = 'yourcookie';

$userid = '9868652404'; // relaxing.media

$follow = new InstagramUserUnFollow();
$follow->SetCookie($datacookie);
$results = $follow->Process($userid);

echo "<pre>";
var_dump($results);
echo "</pre>";