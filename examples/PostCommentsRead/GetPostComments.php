<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramPostCommentsRead;

$datacookie = 'yourcookie';

$shortcode = 'CBeJ1blg_7B';

$readcomments = new InstagramPostCommentsRead();
$readcomments->SetCookie($datacookie);
$results = $readcomments->Process($shortcode);

// $edges = $results['data']['shortcode_media']['edge_media_to_parent_comment']['edges'];
// foreach ($edges as $node) {

//   $comment = $node['node'];
//   $count_reply = $comment['edge_threaded_comments']['count'];
//   $user = $comment['owner'];
//   $haslike = $comment['viewer_has_liked'];

//   $extract[] = [
//   'id' => $comment['id'],
//   'text' => $comment['text'],
//   'userid' => $user['id'],
//   'username' => $user['username'],
//   'haslike' => $haslike,
//   'count_reply' => $count_reply
//   ];
// }

// $next_page = $results['data']['shortcode_media']['edge_media_to_parent_comment']['page_info'];
// if ($next_page['has_next_page']) {
//   $next_id = $next_page['end_cursor'];
// }else{
//   $next_id = false;
// }

// echo json_encode($extract);
// exit;

echo "<pre>";
var_dump($results);
echo "</pre>";