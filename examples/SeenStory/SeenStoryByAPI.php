<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramFeedStoryAPI;
use Riedayme\InstagramKit\InstagramSeenStoryAPI;

$datacookie = 'csrftoken=Yn1MTkVqFeXtSU7lV3OGHdKDnegQVYN0;ds_user_id=31310607724;fbm_124024574287414=base_domain=.instagram.com;fbsr_124024574287414=i8BHv-3KGU6VukWC9jodcanpepQAJi_InsznKDGeIVI.eyJ1c2VyX2lkIjoiMTAwMDE2ODY1NzAzMzc0IiwiY29kZSI6IkFRRFdHeXlRUDBtZ2ZyajlCc2ZSdXE2bkt4SVhyYXJ0azQtZ2pjYnJNRzFLQzNwUlVpeFctT2RkX1lVdng0SWgxNGtXeHJLak9jUW5qMmdQbGUtQXE1QjBYeWdEcmx4bE5NYjFCcnV4Q1J1d1JiVl9xc2lGTDgwUndHU0hrd2Z4TExHU1pkRVhSRzRNOW9UckFiRWZOb1lYR2ZVUFFENkZyZjF5YzRyZ3QtbVJYendzZDJpYmJDb1ZfQWx3V29ZcUowUFUwU3dyT3FzRlZ2cGlLajQyMGxOMm5WTVFrRXc1ZTBWSktSM3dqeThPMjhqR1gxcEtaQm13c19FTGxBY041VjZFN19RNU56SjZ5elhnbVNfdGgtZWZrRFZ0ZTF0OGNKYzF1XzlZQXh3UzlEWHc2LWFNLWpicS1DOHBBRjNpTHZCTTBla1JxQVBSYVRYRUtqRkFRMDlTIiwib2F1dGhfdG9rZW4iOiJFQUFCd3pMaXhuallCQVBKMVJwTjJST0hKYWdFRzZaQzRENnA0a01HakE2RmtaQnJ6Y0l1dDBDeVVHdUk0VWdORTNuWkJMc0RTUWhiN2d0Qm9aQmJ0TlQ1Mkw2eUVQRXZRVGFwcExzMlVHcEhBaFFkZ1RBdUFncWxsa21weVpDd3hwaktzalBGWkJRWkNaQmJxR0FaQ01ublpCbTRvSW5TZ05Lczk0cURCYVhjbFYzWGVydnRaQTU3RUFaQVpBIiwiYWxnb3JpdGhtIjoiSE1BQy1TSEEyNTYiLCJpc3N1ZWRfYXQiOjE1OTI1NjAxOTB9;ig_did=D0E2DBA9-2CEE-459D-B501-A3A1AC6A1553;mid=XulV_QAEAAFxBhSklSTSSy1C2dbV;rur=VLL;sessionid=31310607724%3AzOAz9Nqs2Jguc6%3A20;shbid=8056;shbts=1592470793.4282007;urlgen="{\"180.244.232.112\": 7713}:1jmDeo:EOMIdNgY7k5swUr0yzulY_8ZlCU";';

$useridtarget = '13320596140';

$readstory = new InstagramFeedStoryAPI();
$readstory->SetCookie($datacookie);
$StoryUser = $readstory->GetStoryUser($useridtarget);

// echo json_encode($StoryUser);
// exit;

$seenstory = new InstagramSeenStoryAPI();
$seenstory->SetCookie($datacookie);
$seenstory->SetOption([
  'story_questions' => [
  'active' => true,
  'message' => 'wih mantap bosqu~'
  ],
  'story_polls' => [
  'active' => true,
  'vote' => rand(0,1)
  ],
  'story_countdowns' => [
  'active' => true
  ],
  'story_sliders' => [
  'active' => true,
  'vote' => '1'
  ]
  ]);

foreach ($StoryUser as $story) {

  $results = $seenstory->SeenStoryByAPI($story);
  echo "<pre>";
  var_dump($results);
  echo "</pre>";
}

/*
array(3) {
  ["status"]=>
  bool(true)
  ["id"]=>
  string(19) "2334166284923520094"
  ["username"]=>
  string(12) "fauzan121002"
}
*/