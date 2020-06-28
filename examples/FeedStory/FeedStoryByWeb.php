<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramFeedStory;

$datacookie = 'yourcookie';

$userid = '13320596140';

$feedstory = new InstagramFeedStory();
$feedstory->SetCookie($datacookie);

$story = $feedstory->Process();

if (!$story['status']) {
  die($story['response']);
}

$results = $feedstory->Extract($story);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(10) {
  [0]=>
  array(2) {
    ["id"]=>
    string(10) "5492095809"
    ["username"]=>
    string(12) "fauzan121002"
  }
  [1]=>
  array(2) {
    ["id"]=>
    string(11) "33764627865"
    ["username"]=>
    string(11) "lailia_ftri"
  }
  [2]=>
  array(2) {
    ["id"]=>
    string(11) "30840416655"
    ["username"]=>
    string(9) "queennput"
  }
  [3]=>
  array(2) {
    ["id"]=>
    string(11) "32691606959"
    ["username"]=>
    string(12) "akbar27_shop"
  }
  [4]=>
  array(2) {
    ["id"]=>
    string(10) "8594368183"
    ["username"]=>
    string(9) "itsmezak_"
  }
  [5]=>
  array(2) {
    ["id"]=>
    string(9) "306562176"
    ["username"]=>
    string(12) "twin_mel1719"
  }
  [6]=>
  array(2) {
    ["id"]=>
    string(11) "34714012464"
    ["username"]=>
    string(14) "afri_frizelo27"
  }
  [7]=>
  array(2) {
    ["id"]=>
    string(10) "7207151592"
    ["username"]=>
    string(15) "frontendmasters"
  }
  [8]=>
  array(2) {
    ["id"]=>
    string(10) "4289198852"
    ["username"]=>
    string(16) "ahmadd_musthofa_"
  }
  [9]=>
  array(2) {
    ["id"]=>
    string(9) "321718805"
    ["username"]=>
    string(8) "tugcegrn"
  }
}
*/