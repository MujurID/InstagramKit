<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramUserFollow;

$datacookie = 'yourcookie';

$userid = '9868652404'; // relaxing.media

$follow = new InstagramUserFollow();
$follow->SetCookie($datacookie);
$results = $follow->Process($userid);

echo "<pre>";
var_dump($results);
echo "</pre>";