<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramFeedStory;

$datacookie = 'yourcookie';

$process = new InstagramFeedStory();
$process->SetCookie($datacookie);
// $StoryList = $process->GetStoryList();
$StoryList[] = ['id' => '13320596140'];
$results = $process->GetStoryUser($StoryList);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(7) {
  [0]=>
  array(6) {
    ["id"]=>
    string(19) "2334170092662780662"
    ["userid"]=>
    string(11) "30068297676"
    ["username"]=>
    string(15) "vicky_zeaulotus"
    ["media"]=>
    string(238) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/103915259_260069515252178_4544769233773690333_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=102&_nc_ohc=-3fdQVfUX-YAX-0qcCW&oh=a1c57744c462c9914b3438203e27a3d4&oe=5EEDFD72"
    ["type"]=>
    string(5) "image"
    ["taken_at"]=>
    int(1592474772)
  }
  [1]=>
  array(6) {
    ["id"]=>
    string(19) "2333679798977522274"
    ["userid"]=>
    string(11) "12911408567"
    ["username"]=>
    string(11) "odi_setia27"
    ["media"]=>
    string(235) "https://scontent-sin6-2.cdninstagram.com/v/t50.12441-16/104291959_354864758816883_4457138031183419386_n.mp4?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=103&_nc_ohc=ZvTrn4pqjOIAX8u1SLV&oe=5EEE292B&oh=2ac7f94042c9f079c899656ce555970f"
    ["type"]=>
    string(5) "video"
    ["taken_at"]=>
    int(1592416366)
  }
  [2]=>
  array(6) {
    ["id"]=>
    string(19) "2333678375298016810"
    ["userid"]=>
    string(10) "7673389999"
    ["username"]=>
    string(10) "pinkayepe_"
    ["media"]=>
    string(235) "https://scontent-sin6-2.cdninstagram.com/v/t50.12441-16/103333113_705928956906609_3935005479493917640_n.mp4?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=109&_nc_ohc=xf43nFr3o74AX_z3MRD&oe=5EEDB19D&oh=74eb7ea8e0f00e4510a9da2ece645eea"
    ["type"]=>
    string(5) "video"
    ["taken_at"]=>
    int(1592416151)
  }
  [3]=>
  array(6) {
    ["id"]=>
    string(19) "2334251916336463766"
    ["userid"]=>
    string(10) "3663252070"
    ["username"]=>
    string(11) "kawankoding"
    ["media"]=>
    string(238) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/103963351_268742054190578_1706689948048774330_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=102&_nc_ohc=z7uSOkaORwkAX8WPZl2&oh=0cde77cd84315f2c8c2efb9ac18abf03&oe=5EEE0129"
    ["type"]=>
    string(5) "image"
    ["taken_at"]=>
    int(1592484530)
  }
  [4]=>
  array(6) {
    ["id"]=>
    string(19) "2333690156099678989"
    ["userid"]=>
    string(9) "321718805"
    ["username"]=>
    string(8) "tugcegrn"
    ["media"]=>
    string(238) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/103943875_274287383916070_2061109459702272941_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=110&_nc_ohc=vlanMb0zXk4AX_HtsEU&oh=95cfd8e646c933735db57938c906ee47&oe=5EEDE0B9"
    ["type"]=>
    string(5) "image"
    ["taken_at"]=>
    int(1592417561)
  }
  [5]=>
  array(6) {
    ["id"]=>
    string(19) "2334331908643241737"
    ["userid"]=>
    string(9) "306562176"
    ["username"]=>
    string(12) "twin_mel1719"
    ["media"]=>
    string(235) "https://scontent-sin6-2.cdninstagram.com/v/t50.12441-16/105307508_268479957755414_3372699567100200361_n.mp4?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=102&_nc_ohc=wrHrIHsksIIAX_80tml&oe=5EED9270&oh=e4d6c9ac64d5c147fca382a73d0a9224"
    ["type"]=>
    string(5) "video"
    ["taken_at"]=>
    int(1592494065)
  }
  [6]=>
  array(6) {
    ["id"]=>
    string(19) "2334166284923520094"
    ["userid"]=>
    string(10) "5492095809"
    ["username"]=>
    string(12) "fauzan121002"
    ["media"]=>
    string(238) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/103697088_902473753561839_3302760667021635618_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=103&_nc_ohc=d1g6wTHZxZkAX8nvPDo&oh=5ceb04cf078447ecbec75b63457e277a&oe=5EEE0E0E"
    ["type"]=>
    string(5) "image"
    ["taken_at"]=>
    int(1592474322)
  }
}
*/