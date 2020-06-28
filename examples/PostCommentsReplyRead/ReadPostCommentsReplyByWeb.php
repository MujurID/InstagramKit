<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramPostCommentsReplyRead;

$datacookie = 'yourcookie';

$commentid = '17893046791541968'; // riedayme post

$readreplycomments = new InstagramPostCommentsReplyRead();
$readreplycomments->SetCookie($datacookie);

$cursor = false;
$all_data = array();
$count = 0;
$limit = 1;
do {
  
  $post = $readreplycomments->Process($commentid,$cursor);

  if (!$post['status']) {
    echo $post['response'];
    break;
  }
  
  $data = $readreplycomments->Extract($post);

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