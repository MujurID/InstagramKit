<?php namespace Riedayme\InstagramKit;


Class InstagramPostCommentsReplyRead
{

	public $cookie;	

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}

	public function Process($commentid,$fetch_media_item_cursor = false)
	{

		if ($fetch_media_item_cursor) {
			$variables = '{"comment_id":"'. $commentid .'","first":35,"after":"'. $fetch_media_item_cursor .'"}';			
			$url = 'https://www.instagram.com/graphql/query/?query_hash=1ee91c32fc020d44158a3192eda98247&variables='.urlencode($variables);
		}else{
			$variables = '{"comment_id":"'. $commentid .'","first":35,"after":""}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=1ee91c32fc020d44158a3192eda98247&variables='.urlencode($variables);
		}

		$headers = array();
		$headers[] = "Cookie: ".$this->cookie;
		$headers[] = "X-Csrftoken: ".$this->csrftoken;

		$useragent = InstagramUserAgent::Get('Windows');

		$access = InstagramHelper::curl($url, false , $headers, false, $useragent);

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok' AND $response['data']['comment']['edge_threaded_comments']['edges'] != null) {		

			$next_page = $response['data']['comment']['edge_threaded_comments']['page_info'];
			if ($next_page['has_next_page']) {
				$cursor = $next_page['end_cursor'];
			}else{
				$cursor = false;
			}

			return [
				'status' => true,
				'response' => $response,
				'cursor' => $cursor
			];

		}else{

			if ($response['status'] == 'ok') {

				return [
					'status' => false,
					'response' => 'no_reply'
				];
			}

			return [
				'status' => false,
				'response' => $access['body']
			];
		}
	}

	public function Extract($response){

		if (!$response['status']) return $response;

		$jsondata = $response['response'];
		$edges = $jsondata['data']['comment']['edge_threaded_comments']['edges'];

		$extract = array();
		foreach ($edges as $node) {

			$comment = $node['node'];
			$user = $comment['owner'];
			$haslike = $comment['viewer_has_liked'];

			$extract[] = [
				'id' => $comment['id'],
				'text' => $comment['text'],
				'userid' => $user['id'],
				'username' => $user['username'],
				'haslike' => $haslike
			];
		}

		return $extract;
	}

}