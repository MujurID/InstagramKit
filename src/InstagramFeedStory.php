<?php namespace Riedayme\InstagramKit;

Class InstagramFeedStory
{

	public $cookie;	
	public $csrftoken;

	public $query_hash;	

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
		$this->query_hash = self::GetQueyHash();
	}

	public function GetQueyHash()
	{

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$access = InstagramHelper::curl('https://www.instagram.com/', false, $headers);

		$response =  $access['body'];

		preg_match('/query_hash=([^\s]+)/', $response, $matches);

		if (!empty($matches)) {
			$query_hash = explode('=',$matches[0]);
			$query_hash = explode('&amp',$query_hash[1]);
			$query_hash = $query_hash[0];

			return $query_hash;
		}else{
			die('[ERROR] Tidak dapat mengambil query_hash');
		}
	}	

	public function GetStoryList()
	{

		$url = 'https://www.instagram.com/graphql/query/?query_hash='.$this->query_hash.'&variables=%7B%7D';

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$access = InstagramHelper::curl($url, false , $headers);

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok' AND $response['data']['user'] != null) {
			return self::ExtractStoryList($response);		
		}else{
			// Tidak dapat mengambil feed story list
			// {"message": "invalid query_hash", "status": "fail"}
			return false;
		}
	}	

	public function ExtractStoryList($response)
	{

		$node = $response['data']['user']['feed_reels_tray']['edge_reels_tray_to_reel']['edges'];

		$extract = array();
		foreach ($node as $key => $postdata) {

			$userid = $postdata['node']['id'];
			$username = $postdata['node']['user']['username'];

			$extract[] = [
				'id' => $userid,
				'username' => $username
			];

		}

		if (count($extract) < 1) return false;

		return $extract;
	}	

	public function BuildStoryUserURL($response)
	{

		foreach ($response as $key => $user) {
			$user_ids[] = $user['id'];
		}

		$variables = '{"reel_ids":'.json_encode($user_ids,true).',"tag_names":[],"location_ids":[],"highlight_reel_ids":[],"precomposed_overlay":false,"show_story_viewer_list":true,"story_viewer_fetch_count":50,"story_viewer_cursor":"","stories_video_dash_manifest":false}';

		$url = "https://www.instagram.com/graphql/query/?query_hash=0a85e6ea60a4c99edc58ab2f3d17cfdf&variables={$variables}";

		return $url;
	}

	public function GetStoryUser($response)
	{

		$url = self::BuildStoryUserURL($response);

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$access = InstagramHelper::curl($url, false , $headers);

		$response = json_decode($access['body'],true);

		// echo $access['body'];
		// exit;

		if ($response['status'] == 'ok' AND $response['data']['reels_media'] != null) {
			return self::ExtractStoryUser($response);		
		}else{
			// Tidak dapat mengambil feed story user
			return false;
		}
	}	

	public function ExtractStoryUser($response)
	{
		$reels_media = $response['data']['reels_media'];

		$extract = array();
		foreach ($reels_media as $storylist) {

			$userid = $storylist['user']['id'];
			$username = $storylist['user']['username'];

			$items = $storylist['items'];
			foreach ($items as $story) {
				$id = $story['id'];
				$type = ($story['is_video'] == false) ? 'image' : 'video';
				$media = ($type == 'image') ? $story['display_url'] : $story['video_resources'][0]['src'];
				$taken_at = $story['taken_at_timestamp'];

				$extract[] = [
					'id' => $id,
					'userid' => $userid,				
					'username' => $username,
					'media' => $media,
					'type' => $type,
					'taken_at' => $taken_at
				];
			}

		}

		return $extract;
	}
}