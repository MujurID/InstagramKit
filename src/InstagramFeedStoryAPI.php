<?php namespace Riedayme\InstagramKit;

Class InstagramFeedStoryAPI
{

	public $cookie;	

	public function SetCookie($data) 
	{
		$this->cookie = $data;
	}

	public function GetStoryList($userid)
	{
		// $url = 'https://i.instagram.com/api/v1/feed/reels_tray/';
	}	

	public function GetStoryUser($userid)
	{

		$url = 'https://i.instagram.com/api/v1/feed/user/'.$userid.'/reel_media/';

		$access = InstagramHelperAPI::curl($url, false , false , $this->cookie , InstagramUserAgent::Get('Android'));

		// echo $access['body'];
		// exit;
		
		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok' AND $response['items'] != null) {
			return self::Extract($response);		
		}else{
			// Tidak dapat mengambil feed story user
			return false;
		}
	}	

	public function Extract($response)
	{
		$extract = array();

		$userid = $response['user']['pk'];		
		$username = $response['user']['username'];

		$items = $response['items'];
		foreach ($items as $story) {
			$id = $story['pk'];
			$type = ($story['media_type'] == '1') ? 'image' : 'video';
			$media = ($type == 'image') ? $story['image_versions2']['candidates'][0]['url'] : $story['video_versions'][0]['url'];
			$taken_at = $story['taken_at'];

			/** get polling,question,and other here if exist */

			$story_data['type'] = 'default';

			if (array_key_exists('story_questions', $story)) {

				$read_questions = $story['story_questions'][0]['question_sticker'];

				$story_data['type'] = 'questions';
				$story_data['id'] = $read_questions['question_id'];
				$story_data['question'] = $read_questions['question'];
			}

			elseif (array_key_exists('story_polls', $story)) {

				$read_polls = $story['story_polls'][0]['poll_sticker'];

				$story_data['type'] = 'polls';
				$story_data['id'] = $read_polls['poll_id'];
				$story_data['question'] = $read_polls['question'];
			}		

			elseif (array_key_exists('story_countdowns', $story)) {

				$read_countdowns = $story['story_countdowns'][0]['countdown_sticker'];

				$story_data['type'] = 'countdowns';
				$story_data['id'] = $read_countdowns['countdown_id'];
				$story_data['text'] = $read_countdowns['text'];
			}

			elseif (array_key_exists('story_sliders', $story)) {

				$read_sliders = $story['story_sliders'][0]['slider_sticker'];

				$story_data['type'] = 'sliders';
				$story_data['id'] = $read_sliders['slider_id'];
				$story_data['question'] = $read_sliders['question'];
			}	

			elseif (array_key_exists('story_quizs', $story)) {

				$read_quizs = $story['story_quizs'][0]['quiz_sticker'];

				$story_data['type'] ='quizs';
				$story_data['id'] = $read_quizs['quiz_id'];
				$story_data['question'] = $read_quizs['question'];
				$story_data['count_question'] = count($read_quizs['tallies']);				
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

		return $extract;
	}
}