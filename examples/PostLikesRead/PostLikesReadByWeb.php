<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramPostLikesRead;

$datacookie = 'yourcookie';

$shortcode = 'CB8BcOyAccF'; // post url : https://www.instagram.com/p/CB8BcOyAccF/

$readcomments = new InstagramPostLikesRead();
$readcomments->SetCookie($datacookie);

$cursor = false;
$all_data = array();
$count = 0;
$limit = 5;
do {
  
  $post = $readcomments->Process($shortcode,$cursor);

  if (!$post['status']) {
    echo $post['response'];
    break;
  }
  
  $data = $readcomments->Extract($post);

  $all_data = array_merge($all_data,$data);

  if ($post['cursor'] !== null) {
    $cursor = $post['cursor'];
  }else{
    $cursor = false;
  }

  $count = $count+1;
} while ($cursor !== false AND $count < $limit);


echo "<pre>";
var_dump($all_data);
echo "</pre>";