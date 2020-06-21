<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramPostCommentsReplyRead;

$datacookie = 'yourcookie';

$commentid = '17893046791541968';

$readcomments = new InstagramPostCommentsReplyRead();
$readcomments->SetCookie($datacookie);
$results = $readcomments->Process($commentid);

// $edges = $results['data']['comment']['edge_threaded_comments']['edges'];
// foreach ($edges as $node) {

//   $comment = $node['node'];
//   $user = $comment['owner'];
//   $haslike = $comment['viewer_has_liked'];

//   $extract[] = [
//   'id' => $comment['id'],
//   'text' => $comment['text'],
//   'userid' => $user['id'],
//   'username' => $user['username'],
//   'haslike' => $haslike
//   ];
// }

// $next_page = $results['data']['comment']['edge_threaded_comments']['page_info'];
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