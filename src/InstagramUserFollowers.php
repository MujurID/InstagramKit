<?php namespace Riedayme\InstagramKit;


Class InstagramUserFollowers
{

	public $cookie;	

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}

	public function Process($userid,$fetch_media_item_cursor = false)
	{

		if ($fetch_media_item_cursor) {
			$variables = '{"id":"'. $userid .'","include_reel":true,"fetch_mutual":false,"first":50,"after":"'. $fetch_media_item_cursor .'"}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=c76146de99bb02f6415203be841dd25a&variables='.urlencode($variables);
		}else{
			$variables = '{"id":"'. $userid .'","include_reel":true,"fetch_mutual":false,"first":50}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=c76146de99bb02f6415203be841dd25a&variables='.urlencode($variables);
		}

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$access = InstagramHelper::curl($url, false , $headers);

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok' AND $response['data']['user']['edge_followed_by']['edges'] != null) {		

			$cursor = $response['data']['user']['edge_followed_by']['page_info']['end_cursor'];

			return [
				'status' => true,
				'response' => $response,
				'cursor' => $cursor
			];

		}else{

			if ($response['status'] == 'ok') {

				return [
					'status' => false,
					'response' => 'no_followers'
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
		$edges = $jsondata['data']['user']['edge_followed_by']['edges'];

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