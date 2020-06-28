<?php namespace Riedayme\InstagramKit;

Class InstagramUserStory
{

	public $cookie;	
	public $csrftoken;

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}

	public function BuildStoryUserURL($user_ids)
	{		

		$variables = '{"reel_ids":'.json_encode($user_ids,true).',"tag_names":[],"location_ids":[],"highlight_reel_ids":[],"precomposed_overlay":false,"show_story_viewer_list":true,"story_viewer_fetch_count":50,"story_viewer_cursor":"","stories_video_dash_manifest":false}';

		$url = "https://www.instagram.com/graphql/query/?query_hash=0a85e6ea60a4c99edc58ab2f3d17cfdf&variables={$variables}";

		return $url;
	}

	public function Process($user_ids)
	{

		$url = self::BuildStoryUserURL($user_ids);

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$access = InstagramHelper::curl($url, false , $headers);

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok' AND $response['data']['reels_media'] != null) {		

			return [
				'status' => true,
				'response' => $response
			];

		}else{

			if ($response['status'] == 'ok') {

				return [
					'status' => false,
					'response' => 'no_story'
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

		$jsondata = $response['response'];
		$reels_media = $jsondata['data']['reels_media'];

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

				/** get polling,question,and other here if exist */
				$story_data = []; /* reset value */
				$story_data['type'] = 'default';

				if (!empty($story['tappable_objects'][0])) {

					if ($story['tappable_objects'][0]['__typename'] == 'GraphTappableStoryPoll') 
					{

						$read_polls = $story['tappable_objects'][0];

						$story_data['type'] = 'polls';
						$story_data['id'] = $read_polls['id'];
						$story_data['question'] = $read_polls['question'];
						$story_data['viewer_vote'] = (!empty($read_polls['viewer_vote']) ? true : false);		
					}

					elseif ($story['tappable_objects'][0]['__typename'] == 'GraphTappableFallback') 
					{
						
						$read_tappable = $story['tappable_objects'][0];

						if ($read_tappable['tappable_type'] == 'question') 
						{
							$story_data['type'] = 'questions';
						}
						elseif ($read_tappable['tappable_type'] == 'countdown') 
						{
							$story_data['type'] = 'countdowns';
						}
						elseif ($read_tappable['tappable_type'] == 'slider')
						{
							$story_data['type'] = 'sliders';
						}

					}

				}

				$extract[] = [
					'id' => $id,
					'userid' => $userid,				
					'username' => $username,
					'media' => $media,
					'type' => $type,
					'taken_at' => $taken_at,
					'story_detail' => $story_data,
				];
			}

		}

		return $extract;
	}
}