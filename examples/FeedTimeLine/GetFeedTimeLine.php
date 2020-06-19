<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramFeedTimeLine;

$datacookie = 'yourcookie';

$read = new InstagramFeedTimeLine();
$read->SetCookie($datacookie);

$results = $read->GetFeedTimeLine([
	'type' => 'graphql', /* scraping / graphql */
	'deep' => 1
]);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(10) {
  [0]=>
  array(9) {
    ["id"]=>
    string(19) "2333549506246534412"
    ["username"]=>
    string(16) "sayyid_musthofa_"
    ["code"]=>
    string(11) "CBibumJnOUM"
    ["url"]=>
    string(40) "https://www.instagram.com/p/CBibumJnOUM/"
    ["media"]=>
    string(239) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/104147653_1612513872239435_4301843982633890604_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=111&_nc_ohc=XG9exnDsynIAX9-C7pf&oh=e2fe2e2fa0b3d499b4df090e7b37617b&oe=5F1500F3"
    ["type"]=>
    string(5) "image"
    ["caption"]=>
    string(537) "Sehat Tarus Bib❤️
Follow : 
@sayyid_musthofa_ 
@sayyid_musthofa_ 
@sayyid_musthofa_ .
.
.
#lfl #lflf #fff #fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff #ffff #habibhanifalatas #habibhanifalathos #habibsyech #syekhermania #sholawat #santrihits #followme #dalwa #qoutes #repost #tarimlovers #yummy #ustadzabdulsomad #ustadzadihidayat #hananattaki #instafashion #sayyidalwiassegaf #viral #borneo #mtp #pecintahabaib #guruzuhdiannor #guruzuhdi #abahhaji #ulamabanjar"
    ["haslike"]=>
    bool(false)
    ["is_sidecar"]=>
    bool(false)
  }
}
*/