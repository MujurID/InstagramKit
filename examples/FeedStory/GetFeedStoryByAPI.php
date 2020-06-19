<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramFeedStoryAPI;

$datacookie = 'yourcookie';

$userid = '13320596140';

$read = new InstagramFeedStoryAPI();
$read->SetCookie($datacookie);
// $results = $read->GetStoryList();
$results = $read->GetStoryUser($userid);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(1) {
  [0]=>
  array(6) {
    ["id"]=>
    int(2334422268499052739)
    ["userid"]=>
    int(13320596140)
    ["username"]=>
    string(9) "faanteyki"
    ["media"]=>
    string(286) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/104007689_568852740334218_1259789215103980073_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=106&_nc_ohc=rQEr8M1x-NUAX9CD_rQ&oh=51e7255ccd69455689913c4410a14bd3&oe=5EEE29C6&ig_cache_key=MjMzNDQyMjI2ODQ5OTA1MjczOQ%3D%3D.2"
    ["type"]=>
    string(5) "image"
    ["taken_at"]=>
    int(1592504833)
  }
}
*/