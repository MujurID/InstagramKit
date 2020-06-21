<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramUserFollowersAPI;

$datacookie = 'yourcookie';

$useridtarget = '13320596140';

$readfollowers = new InstagramUserFollowersAPI();
$readfollowers->SetCookie($datacookie);
$results = $readfollowers->Process($useridtarget);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(2) {
  [0]=>
  array(5) {
    ["userid"]=>
    int(3270262328)
    ["username"]=>
    string(12) "fitriani_f.a"
    ["is_private"]=>
    bool(false)
    ["photo"]=>
    string(243) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-19/s150x150/103774177_286641316036921_2718259680549354379_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=101&_nc_ohc=Xt-nW38hLGwAX-HPXbF&oh=487b4edb8f6abef3deaaccc58e9e299a&oe=5F16E86A"
    ["latest_reel_media"]=>
    int(1592475703)
  }
  [1]=>
  array(5) {
    ["userid"]=>
    int(16473604761)
    ["username"]=>
    string(10) "adhedinar_"
    ["is_private"]=>
    bool(false)
    ["photo"]=>
    string(242) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-19/s150x150/79600278_605357926925921_4315612031265800192_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=105&_nc_ohc=WxLydxtiky4AX9b7z-S&oh=822de79816af7b6c9126ef25dc9dbe09&oe=5F17A1F8"
    ["latest_reel_media"]=>
    int(1592547531)
  }
}
*/