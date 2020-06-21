<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramFeedStoryAPI;

$datacookie = 'yourcookie';

$user_ids = ['13320596140','3555900579'];

$read = new InstagramFeedStoryAPI();
$read->SetCookie($datacookie);
// $results = $read->GetStoryList();
$results = $read->GetStoryUser($user_ids);

// echo json_encode($results);
// exit;

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
[
  {
    "id": 2336332851137925320,
    "userid": 13320596140,
    "username": "faanteyki",
    "media": "https:\/\/scontent-sin6-1.cdninstagram.com\/v\/t51.12442-15\/e35\/104166755_509334949785072_7809417979016620015_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=100&_nc_ohc=BvfiaF0M2ZIAX_mMGrM&oh=52e0408feca2cc2c5016b33b97094860&oe=5EF151C6&ig_cache_key=MjMzNjMzMjg1MTEzNzkyNTMyMA%3D%3D.2",
    "type": "image",
    "taken_at": 1592732595,
    "story_detail": {
      "type": "questions",
      "id": 17851435034121612,
      "question": "Do something",
      "can_reply": false
    }
  }
]
*/