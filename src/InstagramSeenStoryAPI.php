<?php namespace Riedayme\InstagramKit;

Class InstagramSeenStoryAPI
{

	public $cookie;	

	public $option = array();

	public function SetCookie($data) 
	{
		$this->cookie = $data;
	}

	public function SetOption($data) 
	{
		$this->option = $data;
	}	

	public function SeenStoryByAPI($storydata)
	{


		$is_vod = false;

		$params = '?' . ($is_vod==false ? 'reel=1' : 'reel=0') . '&' . ($is_vod==true ? 'live_vod=1' : 'live_vod=0');

		$url = 'https://i.instagram.com/api/v1/media/seen/'.$params;

		$reelId_o = $storydata['id'];
		$reelId = $storydata['id']."_".$storydata['userid'];
		$reels_real[$reelId] = $storydata['taken_at'].'_'.time();

		$data = json_encode([
			'reels'      => ($is_vod == false ? $reels_real : []),
			'live_vods'  => ($is_vod == true ? $reels_real : [])
			]);	

		$postdata = InstagramHelperAPI::generateSignature($data);

		$access = InstagramHelperAPI::curl($url, $postdata , false , $this->cookie , InstagramUserAgent::Get('Android'));

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok') {
			
			$story_response = 'success';

			if ($storydata['story_detail']['type'] == 'questions') 
			{
				$story_response = self::seen_story_questions($storydata);
			}
			elseif ($storydata['story_detail']['type'] == 'polls') 
			{
				$story_response = self::seen_story_polls($storydata);
			}
			elseif ($storydata['story_detail']['type'] == 'countdowns') 
			{
				$story_response = self::seen_story_countdowns($storydata);
			}
			elseif ($storydata['story_detail']['type'] == 'sliders') 
			{
				$story_response = self::seen_story_sliders($storydata);
			}
			elseif ($storydata['story_detail']['type'] == 'quizs') 
			{
				$story_response = self::seen_story_quizs($storydata);
			}

			return [
			'status' => true,
			'id' => $storydata['id'],
			'username' => $storydata['username'],
			'story_response' => $story_response
			];
		}

		return false;
	}

	public function seen_story_questions($storydata)
	{

		if (!$this->option['story_questions']['active']) return false;

		$url = 'https://i.instagram.com/api/v1/media/'.$storydata['id'].'/'.$storydata['story_detail']['id'].'/story_question_response/';

		$data = json_encode([
			'response' => $this->option['story_questions']['message'],
			'type' => 'text'
			]);	

		$postdata = InstagramHelperAPI::generateSignature($data);

		$access = InstagramHelperAPI::curl($url, $postdata , false , $this->cookie , InstagramUserAgent::Get('Android'));

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok') {
			return "succes answer question {$storydata['story_detail']['id']} | message : {$this->option['story_questions']['message']}";
		}

		return $access['body'];
	}

	public function seen_story_polls($storydata)
	{

		if (!$this->option['story_polls']['active']) return false;

		$url = 'https://i.instagram.com/api/v1/media/'.$storydata['id'].'/'.$storydata['story_detail']['id'].'/story_poll_vote/';

		$data = json_encode([
			'radio_type' => 'none',
			'vote' => $this->option['story_polls']['vote'],
			]);	

		$postdata = InstagramHelperAPI::generateSignature($data);

		$access = InstagramHelperAPI::curl($url, $postdata , false , $this->cookie , InstagramUserAgent::Get('Android'));

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok') {
			return "succes polling {$storydata['story_detail']['id']} vote : {$this->option['story_polls']['vote']}";
		}

		return $access['body'];
	}

	public function seen_story_countdowns($storydata)
	{

		if (!$this->option['story_countdowns']['active']) return false;

		$url = 'https://i.instagram.com/api/v1/media/'.$storydata['story_detail']['id'].'/follow_story_countdown/';

		$access = InstagramHelperAPI::curl($url, false , false , $this->cookie , InstagramUserAgent::Get('Android'));

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok') {
			return "succes follow story countdown {$storydata['story_detail']['id']}";
		}

		return $access['body'];		
	}

	public function seen_story_sliders($storydata)
	{

		if (!$this->option['story_sliders']['active']) return false;

		$url = 'https://i.instagram.com/api/v1/media/'.$storydata['id'].'/'.$storydata['story_detail']['id'].'/story_slider_vote/';

		$data = json_encode([
			'radio_type' => 'wifi-none',
			'vote' => $this->option['story_sliders']['vote'],
			]);	

		$postdata = InstagramHelperAPI::generateSignature($data);

		$access = InstagramHelperAPI::curl($url, $postdata , false , $this->cookie , InstagramUserAgent::Get('Android'));

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok') {
			return "succes send story sliders {$storydata['story_detail']['id']}";
		}

		return $access['body'];				
	}

	public function seen_story_quizs($storydata)
	{

		if (!$this->option['story_quizs']['active']) return false;

		$url = 'https://i.instagram.com/api/v1/media/'.$storydata['id'].'/'.$storydata['story_detail']['id'].'/story_quiz_answer/';

		$data = json_encode([
			'answer' => rand(0,3),
			]);	

		$postdata = InstagramHelperAPI::generateSignature($data);

		$access = InstagramHelperAPI::curl($url, $postdata , false , $this->cookie , InstagramUserAgent::Get('Android'));
		
		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok') {
			return "succes send story quiz {$storydata['story_detail']['id']}";
		}

		return $access['body'];				
	}	
}