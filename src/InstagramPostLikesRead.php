<?php namespace Riedayme\InstagramKit;


Class InstagramPostLikesRead
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
			$variables = '{"shortcode":"'. $shortcode .'","include_reel":true,"first":35,"after":"'. $fetch_media_item_cursor .'"}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=d5d763b1e2acf209d62d22d184488e57&variables='.urlencode($variables);
		}else{
			$variables = '{"shortcode":"'. $shortcode .'","include_reel":true,"first":35}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=d5d763b1e2acf209d62d22d184488e57&variables='.urlencode($variables);
		}

		$headers = array();
		$headers[] = "Cookie: ".$this->cookie;
		$headers[] = "X-Csrftoken: ".$this->csrftoken;

		$useragent = InstagramUserAgent::Get('Windows');

		$access = InstagramHelper::curl($url, false , $headers, false, $useragent);

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok' AND $response['data']['shortcode_media']['edge_liked_by']['edges'] != null) {		

			$next_page = $response['data']['shortcode_media']['edge_liked_by']['page_info'];
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
		$edges = $jsondata['data']['shortcode_media']['edge_liked_by']['edges'];

		$extract = array();
		foreach ($edges as $node) {
			$user = $node['node'];
			$reel = $user['reel'];

			$extract[] = [
				'userid' => $user['id'],
				'username' => $user['username'],
				'photo' => $user['profile_pic_url'],
				'is_private' => $user['is_private'],
				'latest_reel_media' => $reel['latest_reel_media'],
			];
		}

		return $extract;
	}	

}