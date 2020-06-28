<?php namespace Riedayme\InstagramKit;


Class InstagramPostCommentsRead
{

	public $cookie;	

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}

	public function Process($shortcode,$fetch_media_item_cursor = false)
	{

		if ($fetch_media_item_cursor) {
			$variables = '{"shortcode":"'. $shortcode .'","first":35,"after":"'. $fetch_media_item_cursor .'"}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=bc3296d1ce80a24b1b6e40b1e72903f5&variables='.urlencode($variables);
		}else{
			$variables = '{"shortcode":"'. $shortcode .'","first":35,"after":""}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=bc3296d1ce80a24b1b6e40b1e72903f5&variables='.urlencode($variables);
		}

		$headers = array();
		$headers[] = "Cookie: ".$this->cookie;
		$headers[] = "X-Csrftoken: ".$this->csrftoken;

		$useragent = InstagramUserAgent::Get('Windows');

		$access = InstagramHelper::curl($url, false , $headers, false, $useragent);

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok' AND $response['data']['shortcode_media']['edge_media_to_parent_comment']['edges'] != null) {		

			$next_page = $response['data']['shortcode_media']['edge_media_to_parent_comment']['page_info'];
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
					'response' => 'no_comment'
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
		$edges = $jsondata['data']['shortcode_media']['edge_media_to_parent_comment']['edges'];

		$extract = array();
		foreach ($edges as $node) {

			$comment = $node['node'];
			$count_reply = $comment['edge_threaded_comments']['count'];
			$user = $comment['owner'];
			$haslike = $comment['viewer_has_liked'];

			$extract[] = [
				'id' => $comment['id'],
				'text' => $comment['text'],
				'userid' => $user['id'],
				'username' => $user['username'],
				'haslike' => $haslike,
				'count_reply' => $count_reply
			];
		}

		return $extract;
	}	

}