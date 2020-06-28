<?php namespace Riedayme\InstagramKit;

Class InstagramUserPost
{

	public $cookie;	
	public $csrftoken;

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}

	public function Process($userid,$fetch_media_item_cursor = false)
	{

		if ($fetch_media_item_cursor) {
			$variables = '{"id":"'. $userid .'","first":12,"after":"'. $fetch_media_item_cursor .'"}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=eddbde960fed6bde675388aac39a3657&variables='.urlencode($variables);
		}else{
			$variables = '{"id":"'. $userid .'","first":12,"after":""}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=eddbde960fed6bde675388aac39a3657&variables='.urlencode($variables);
		}

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$access = InstagramHelper::curl($url, false , $headers);

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok' AND $response['data']['user']['edge_owner_to_timeline_media']['edges'] != null) {		


			$cursor = $response['data']['user']['edge_owner_to_timeline_media']['page_info']['end_cursor'];

			return [
				'status' => true,
				'response' => $response,
				'cursor' => $cursor
			];

		}else{

			if ($response['status'] == 'ok') {

				return [
					'status' => false,
					'response' => 'no_post'
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
		$edges = $jsondata['data']['user']['edge_owner_to_timeline_media']['edges'];

		$extract = array();
		foreach ($edges as $key => $postdata) {

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

		return $extract;

	}

}