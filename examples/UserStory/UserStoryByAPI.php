<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramUserStoryAPI;

$datacookie = 'yourcookie';

$user_ids = ['3555900579']; // userid iayulstr

$read = new InstagramUserStoryAPI();
$read->SetCookie($datacookie);
$story = $read->Process($user_ids);
$results = $read->Extract($story);

echo "<pre>";
var_dump($results);
echo "</pre>";

/* ExtractStoryUser
array(5) {
  [0]=>
  array(7) {
    ["id"]=>
    int(2340776252302260176)
    ["userid"]=>
    int(3555900579)
    ["username"]=>
    string(8) "iayulstr"
    ["media"]=>
    string(530) "https://scontent-sin6-2.cdninstagram.com/v/t72.14836-16/76681405_574158833289734_7332379942646575979_n.mp4?efg=eyJ2ZW5jb2RlX3RhZyI6InZ0c192b2RfdXJsZ2VuLjcyMC5zdG9yeS5kZWZhdWx0In0&_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=102&_nc_ohc=YR1z07m8jeIAX_UiMu9&vs=17873672371752048_314789233&_nc_vs=HBkcFQAYJEdMMFFrZ1FHaWszRk1Rb0NBR3Z6cFlfMTJNRmxidlE1QUFBRhUAAsgBACgAGAAbAYgHdXNlX29pbAExFQAAGAAW4IiqqdSAwD8VAigCQzMsF0AWzMzMzMzNGBJkYXNoX2Jhc2VsaW5lXzFfdjERAHXoBwA%3D&_nc_rid=1132d6af74&oe=5EFA9FD7&oh=5a360b6e525b915f7abee2ed1c159167"
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
    int(2340776497660708055)
    ["userid"]=>
    int(3555900579)
    ["username"]=>
    string(8) "iayulstr"
    ["media"]=>
    string(531) "https://scontent-sin6-1.cdninstagram.com/v/t72.14836-16/74817591_336054184457575_5555435331493826177_n.mp4?efg=eyJ2ZW5jb2RlX3RhZyI6InZ0c192b2RfdXJsZ2VuLjcyMC5zdG9yeS5kZWZhdWx0In0&_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=107&_nc_ohc=kca0a-sFdvUAX8kG89o&vs=18014401246287109_1576325281&_nc_vs=HBkcFQAYJEdEZWdkUVJuTlVxMm96RUJBSUVPV0FJQTN4aE5idlE1QUFBRhUAAsgBACgAGAAbAYgHdXNlX29pbAExFQAAGAAWirLtoJSAgEAVAigCQzMsF0AWzMzMzMzNGBJkYXNoX2Jhc2VsaW5lXzFfdjERAHXoBwA%3D&_nc_rid=1132dfded4&oe=5EFAC179&oh=cd9d34d3556724bdf151a06dea5093f2"
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
    int(2340811346085921462)
    ["userid"]=>
    int(3555900579)
    ["username"]=>
    string(8) "iayulstr"
    ["media"]=>
    string(595) "https://scontent-sin6-2.cdninstagram.com/v/t72.14836-16/77274560_108981707433718_4476395154031674478_n.mp4?efg=eyJ2ZW5jb2RlX3RhZyI6InZ0c192b2RfdXJsZ2VuLjcyMC5zdG9yeS5kZWZhdWx0In0&_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=110&_nc_ohc=dknJu0odYT8AX8MOSWC&vs=17899815841492937_3821983470&_nc_vs=HBksFQAYJEdNQWRtd1QyWnZWSEhtTUFBRzZFVnZhc1dSOF9idlE1QUFBRhUAAsgBABUAGCRHT2twaWdRM0xjbUxnbVlBQUk2eF85ZVN0S05zYnZRNUFBQUYVAgLIAQAoABgAGwGIB3VzZV9vaWwBMRUAABgAFpL7jKq08ss%2FFQIoAkMzLBdAJap%2B%2Bdsi0RgSZGFzaF9iYXNlbGluZV8xX3YxEQB16AcA&_nc_rid=1132debc51&oe=5EFAEE33&oh=797301106db881faefadd46abab7524d"
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
    int(2340821088900385493)
    ["userid"]=>
    int(3555900579)
    ["username"]=>
    string(8) "iayulstr"
    ["media"]=>
    string(287) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/106237685_3569354539760874_7348013886544305884_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=106&_nc_ohc=AcxBPkhmKFoAX_d912l&oh=017e668a666bbeb2a1a83a934c9b4bb0&oe=5EFAE3C3&ig_cache_key=MjM0MDgyMTA4ODkwMDM4NTQ5Mw%3D%3D.2"
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
    int(2341120668908932359)
    ["userid"]=>
    int(3555900579)
    ["username"]=>
    string(8) "iayulstr"
    ["media"]=>
    string(286) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/106133203_291799528855541_4505135225144565660_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=105&_nc_ohc=-7UfRtWd9IcAX8ZYRQr&oh=efd52b357aaa836fe3577098389e2045&oe=5EFB14E2&ig_cache_key=MjM0MTEyMDY2ODkwODkzMjM1OQ%3D%3D.2"
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