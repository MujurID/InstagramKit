<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramUserStory;

$datacookie = 'yourcookie';

$user_ids = ['3555900579']; // userid iayulstr

$read = new InstagramUserStory();
$read->SetCookie($datacookie);
$story = $read->Process($user_ids);

if (!$story['status']) {
  die($story['response']);
}

$results = $read->Extract($story);

echo "<pre>";
var_dump($results);
echo "</pre>";

/* ExtractStoryUser
array(5) {
  [0]=>
  array(7) {
    ["id"]=>
    string(19) "2340776252302260176"
    ["userid"]=>
    string(10) "3555900579"
    ["username"]=>
    string(8) "iayulstr"
    ["media"]=>
    string(236) "https://scontent-sin6-2.cdninstagram.com/v/t50.12441-16/105455160_2681287085486566_4881596861485171758_n.mp4?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=110&_nc_ohc=I826kAG99R4AX9MiRWQ&oe=5EFAB15C&oh=717207f0b3053f858242484668d9d022"
    ["type"]=>
    string(5) "video"
    ["taken_at"]=>
    int(1593258858)
    ["story_detail"]=>
    array(1) {
      ["type"]=>
      string(7) "default"
    }
  }
  [1]=>
  array(7) {
    ["id"]=>
    string(19) "2340776497660708055"
    ["userid"]=>
    string(10) "3555900579"
    ["username"]=>
    string(8) "iayulstr"
    ["media"]=>
    string(235) "https://scontent-sin6-2.cdninstagram.com/v/t50.12441-16/105291328_303040157558372_5365050743884848933_n.mp4?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=108&_nc_ohc=fv_H7VciXM8AX_MdJP9&oe=5EFAA1B0&oh=4ecce1a1381f09b34c4cbdacf4900143"
    ["type"]=>
    string(5) "video"
    ["taken_at"]=>
    int(1593258883)
    ["story_detail"]=>
    array(1) {
      ["type"]=>
      string(7) "default"
    }
  }
  [2]=>
  array(7) {
    ["id"]=>
    string(19) "2340811346085921462"
    ["userid"]=>
    string(10) "3555900579"
    ["username"]=>
    string(8) "iayulstr"
    ["media"]=>
    string(236) "https://scontent-sin6-2.cdninstagram.com/v/t50.12441-16/105657049_2608520869386257_3167964835080955786_n.mp4?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=105&_nc_ohc=epEoS9zJwWoAX8_kr3l&oe=5EFAB9D0&oh=2428d6e53d31fbe7de3ac2c1d64f45a3"
    ["type"]=>
    string(5) "video"
    ["taken_at"]=>
    int(1593266439)
    ["story_detail"]=>
    array(1) {
      ["type"]=>
      string(7) "default"
    }
  }
  [3]=>
  array(7) {
    ["id"]=>
    string(19) "2340821088900385493"
    ["userid"]=>
    string(10) "3555900579"
    ["username"]=>
    string(8) "iayulstr"
    ["media"]=>
    string(239) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/106237685_3569354539760874_7348013886544305884_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=106&_nc_ohc=AcxBPkhmKFoAX_d912l&oh=017e668a666bbeb2a1a83a934c9b4bb0&oe=5EFAE3C3"
    ["type"]=>
    string(5) "image"
    ["taken_at"]=>
    int(1593267636)
    ["story_detail"]=>
    array(1) {
      ["type"]=>
      string(7) "default"
    }
  }
  [4]=>
  array(7) {
    ["id"]=>
    string(19) "2341120668908932359"
    ["userid"]=>
    string(10) "3555900579"
    ["username"]=>
    string(8) "iayulstr"
    ["media"]=>
    string(238) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/106133203_291799528855541_4505135225144565660_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=105&_nc_ohc=-7UfRtWd9IcAX8ZYRQr&oh=efd52b357aaa836fe3577098389e2045&oe=5EFB14E2"
    ["type"]=>
    string(5) "image"
    ["taken_at"]=>
    int(1593303347)
    ["story_detail"]=>
    array(1) {
      ["type"]=>
      string(7) "default"
    }
  }
}
*/