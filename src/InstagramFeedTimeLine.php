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

	public function Process($fetch_media_item_cursor = false)
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

		if ($response['status'] == 'ok' AND $response['data']['user']['edge_web_feed_timeline']['edges'] != null) {		

			$cursor = $response['data']['user']['edge_web_feed_timeline']['page_info']['end_cursor'];

			return [
				'status' => true,
				'response' => $response,
				'cursor' => $cursor
			];

		}else{

			if ($response['status'] == 'ok') {

				return [
					'status' => false,
					'response' => 'no_feed'
				];
			}

			return [
				'status' => false,
				'response' => $access['body']
			];
		}

	}

	public function Extract($response)
	{

		if (!$response['status']) return $response;

		$jsondata = $response['response'];
		$edges = $jsondata['data']['user']['edge_web_feed_timeline']['edges'];

		$extract = array();
		foreach ($edges as $key => $postdata) {

			/* type not suggest feed becaouse this no id found */
			if ($postdata['node']['__typename'] != 'GraphSuggestedUserFeedUnit') {

				$id =  $postdata['node']['id'];
				$username = $postdata['node']['owner']['username'];
				$code = $postdata['node']['shortcode'];
				$url = "https://www.instagram.com/p/{$code}/";
				$caption = (!empty($postdata['node']['edge_media_to_caption']['edges'])) ? $postdata['node']['edge_media_to_caption']['edges'][0]['node']['text'] : false;
				$haslike = $postdata['node']['viewer_has_liked'];

				if ($postdata['node']['__typename'] == 'GraphSidecar') {

					$SideCarData = $postdata['node']['edge_sidecar_to_children']['edges'];

					$media = array();
					foreach ($SideCarData as $postsidecar) {

						$sidecartype = ($postsidecar['node']['is_video'] == false) ? 'image' : 'video';
						$sidecarmedia = ($sidecartype == 'image') ? $postsidecar['node']['display_url'] : $postsidecar['node']['video_url'];

						$media[] = [
							'media' => $sidecarmedia,
							'type' => $sidecartype,
						];
					}

					$type = 'carousel';
				}elseif ($postdata['node']['__typename'] == 'GraphVideo') {
					$media = $postdata['node']['video_url'];
					$type = 'video';
				}elseif ($postdata['node']['__typename'] == 'GraphImage') {
					$media = $postdata['node']['display_url'];
					$type = 'image';
				}

				$extract[] = [
					'id' => $id,
					'username' => $username,
					'code' => $code,
					'url' => $url,
					'type' => $type,
					'media' => $media,
					'caption' => $caption,
					'haslike' => $haslike,
				];
			}

		}

		return $extract;
	}

}