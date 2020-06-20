<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramAuthAPI;

$required['url'] = 'https://i.instagram.com/challenge/31310607724/L0WCXcVBm1/';
$required['cookie'] = 'csrftoken=dfPzJBiNO3M7u4ILR6U5cfgMrzhWtnUI;rur=ASH;mid=Xuy7QAABAAF-BF_v2Uf0Q0mNo3hH;';
$required['csrftoken'] = 'dfPzJBiNO3M7u4ILR6U5cfgMrzhWtnUI';
$required['security_code'] = '952601';

$auth = new InstagramAuthAPI();

$results = $auth->CheckPointSolve($required);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*

*/