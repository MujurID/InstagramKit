<?php namespace Riedayme\InstagramKit;


Class InstagramFeedTimeLine
{

	public $cookie;	
	public $csrftoken;

	public $FeedTimeLine = array();	
	public $FeedTimeLineType;	

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}

	public function GetFeedTimeLine($data)
	{
		$this->FeedTimeLineType = $data['type'];

		if ($this->FeedTimeLineType == 'graphql') {
			return self::GetFeedTimeLineByGraphQL(false, false,$data['deep']);
		}elseif ($this->FeedTimeLineType == 'scraping') {
			return self::GetFeedTimeLineByScraping(false, false,$data['deep']);
		}else{
			die("Sumber FeedTimeLine Tidak ditemukan.");
		}
	}

	public function GetFeedTimeLineByGraphQL($fetch_media_item_cursor = false,$TryAgain = 1,$Deep = 1)
	{

		if ($fetch_media_item_cursor) {
			$variables = '{"fetch_media_item_cursor":"'.$fetch_media_item_cursor.'","has_stories":false}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=23fb2296d660bfcfd98811aefbe6d463&variables='.urlencode($variables);
		}else{
			$url = 'https://www.instagram.com/graphql/query/?query_hash=23fb2296d660bfcfd98811aefbe6d463&variables=%7B%7D';
		}

		$headers = array();
		$headers[] = "Cookie: ".$this->cookie;

		$useragent = InstagramUserAgent::Get('Windows');

		$access = InstagramHelper::curl($url, false , $headers, false, $useragent);

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok' AND $response['data']['user'] != null) {

			return self::ExtractFeedTimeLine($response,$TryAgain + 1,$Deep);

		}else{
			// Tidak dapat mengambil feed timeline graphql
			return false;
		}

	}

	public function GetFeedTimeLineByScraping($fetch_media_item_cursor = false,$TryAgain = 1,$Deep = 1)
	{

		if ($fetch_media_item_cursor) {
			$variables = '{"fetch_media_item_cursor":"'.$fetch_media_item_cursor.'","has_stories":false}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=23fb2296d660bfcfd98811aefbe6d463&variables='.urlencode($variables);
		}else{
			$url = 'https://www.instagram.com/';
		}

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$access = InstagramHelper::curl($url, false , $headers);

		if ($fetch_media_item_cursor) {
			$response = json_decode($access['body'],true);
		}else{
			$extract = InstagramHelper::GetStringBetween($access['body'], "window.__additionalDataLoaded('feed',", ");</script>");
			if (!$extract) die("Tidak dapat mengambil feed timeline");
			$response['data'] = json_decode($extract,true);
		}

		if ($fetch_media_item_cursor) {
			if ($response['status'] == 'ok' AND $response['data']['user'] == null) {
				// Tidak dapat mengambil feed timeline scraping
				return false;
			}
		}

		return self::ExtractFeedTimeLine($response,$TryAgain + 1,$Deep);
	}

	public function ExtractFeedTimeLine($response,$TryAgain,$Deep)
	{

		$next_page_status = $response['data']['user']['edge_web_feed_timeline']['page_info']['has_next_page'];
		$fetch_media_item_cursor = $response['data']['user']['edge_web_feed_timeline']['page_info']['end_cursor'];

		$node = $response['data']['user']['edge_web_feed_timeline']['edges'];

		foreach ($node as $key => $postdata) {

			/* type not suggest feed becaouse this no id found */
			if ($postdata['node']['__typename'] != 'GraphSuggestedUserFeedUnit') {

				$id =  $postdata['node']['id'];
				$username = $postdata['node']['owner']['username'];
				$code = $postdata['node']['shortcode'];
				$url = "https://www.instagram.com/p/{$code}/";
				$type = ($postdata['node']['is_video'] == false) ? 'image' : 'video';
				$media = ($type == 'image') ? $postdata['node']['display_url'] : $postdata['node']['video_url'];
				$caption = (!empty($postdata['node']['edge_media_to_caption']['edges'])) ? $postdata['node']['edge_media_to_caption']['edges'][0]['node']['text'] : false;
				$haslike = $postdata['node']['viewer_has_liked'];

				$is_sidecar = false;
				if ($postdata['node']['__typename'] == 'GraphSidecar') {

					$SideCarData = $postdata['node']['edge_sidecar_to_children']['edges'];

					foreach ($SideCarData as $postsidecar) {

						$sidecartype = ($postsidecar['node']['is_video'] == false) ? 'image' : 'video';
						$sidecarmedia = ($sidecartype == 'image') ? $postsidecar['node']['display_url'] : $postsidecar['node']['video_url'];

						$is_sidecar[] = [
						'media' => $sidecarmedia,
						'type' => $sidecartype,
						];
					}
				}

				$this->FeedTimeLine[] = [
				'id' => $id,
				'username' => $username,
				'code' => $code,
				'url' => $url,
				'media' => $media,
				'type' => $type,
				'caption' => $caption,
				'haslike' => $haslike,
				'is_sidecar' => $is_sidecar
				];
			}

		}

		/* repeat until 3x if no have FeedTimeLine results > get next page feed */
		if ($TryAgain < $Deep) {

			if ($this->FeedTimeLineType == 'graphql') {
				return self::GetFeedTimeLineByGraphQL($fetch_media_item_cursor,$TryAgain,$Deep);
			}elseif ($this->FeedTimeLineType == 'scraping') {
				return self::GetFeedTimeLineByScraping($fetch_media_item_cursor,$TryAgain,$Deep);
			}

		}

		return $this->FeedTimeLine;
	}

}