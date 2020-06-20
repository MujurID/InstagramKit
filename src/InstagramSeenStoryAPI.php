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

			$seen_story_questions = false;
			if ($storydata['story_questions'] !== false) 
			{
				$seen_story_questions = self::seen_story_questions($storydata);
			}

			$seen_story_polls = false;
			if ($storydata['story_polls'] !== false) 
			{
				$seen_story_polls = self::seen_story_polls($storydata);
			}

			$seen_story_countdowns = false;
			if ($storydata['story_countdowns'] !== false) 
			{
				$seen_story_countdowns = self::seen_story_countdowns($storydata);
			}

			$seen_story_sliders = false;
			if ($storydata['story_sliders'] !== false) 
			{
				$seen_story_sliders = self::seen_story_sliders($storydata);
			}

			$seen_story_quizs = false;
			if ($storydata['story_quizs'] !== false) 
			{
				$seen_story_quizs = self::seen_story_quizs($storydata);
			}

			return [
				'status' => true,
				'id' => $storydata['id'],
				'username' => $storydata['username'],
				'response_story_questions' => $seen_story_questions,
				'response_story_polls' => $seen_story_polls,
				'response_story_countdowns' => $seen_story_countdowns,
				'response_story_sliders' => $seen_story_sliders,
				'response_story_quizs' => $seen_story_quizs,				
			];
		}

		return false;
	}

	public function seen_story_questions($storydata)
	{

		if (!$this->option['story_questions']['active']) return false;

		$url = 'https://i.instagram.com/api/v1/media/'.$storydata['id'].'/'.$storydata['story_questions']['id'].'/story_question_response/';

		$data = json_encode([
			'response' => $this->option['story_questions']['message'],
			'type' => 'text'
		]);	

		$postdata = InstagramHelperAPI::generateSignature($data);

		$access = InstagramHelperAPI::curl($url, $postdata , false , $this->cookie , InstagramUserAgent::Get('Android'));

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok') {
			return "succes answer question {$storydata['story_questions']['id']} message : {$this->option['story_questions']['message']}";
		}

		return false;
	}

	public function seen_story_polls($storydata)
	{

		if (!$this->option['story_polls']['active']) return false;

		$url = 'https://i.instagram.com/api/v1/media/'.$storydata['id'].'/'.$storydata['story_polls']['id'].'/story_poll_vote/';

		$data = json_encode([
			'radio_type' => 'none',
			'vote' => $this->option['story_polls']['vote'],
		]);	

		$postdata = InstagramHelperAPI::generateSignature($data);

		$access = InstagramHelperAPI::curl($url, $postdata , false , $this->cookie , InstagramUserAgent::Get('Android'));

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok') {
			return "succes polling {$storydata['story_polls']['id']} vote : {$this->option['story_polls']['vote']}";
		}

		return false;
	}

	public function seen_story_countdowns($storydata)
	{

		if (!$this->option['story_countdowns']['active']) return false;

		$url = 'https://i.instagram.com/api/v1/media/'.$storydata['story_countdowns']['id'].'/follow_story_countdown/';

		$access = InstagramHelperAPI::curl($url, false , false , $this->cookie , InstagramUserAgent::Get('Android'));

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok') {
			return "succes follow story countdown {$storydata['story_countdowns']['id']}";
		}

		return false;		
	}

	public function seen_story_sliders($storydata)
	{

		if (!$this->option['story_sliders']['active']) return false;

		$url = 'https://i.instagram.com/api/v1/media/'.$storydata['id'].'/'.$storydata['story_sliders']['id'].'/story_slider_vote/';

		$data = json_encode([
			'radio_type' => 'wifi-none',
			'vote' => $this->option['story_sliders']['vote'],
		]);	

		$postdata = InstagramHelperAPI::generateSignature($data);

		$access = InstagramHelperAPI::curl($url, $postdata , false , $this->cookie , InstagramUserAgent::Get('Android'));

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok') {
			return "succes send story sliders {$storydata['story_sliders']['id']}";
		}

		return false;				
	}

	public function seen_story_quizs($storydata)
	{

		if (!$this->option['story_quizs']['active']) return false;

		$url = 'https://i.instagram.com/api/v1/media/'.$storydata['id'].'/'.$storydata['story_quizs']['id'].'/story_quiz_answer/';

		$data = json_encode([
			'answer' => rand(0,3),
		]);	

		$postdata = InstagramHelperAPI::generateSignature($data);

		$access = InstagramHelperAPI::curl($url, $postdata , false , $this->cookie , InstagramUserAgent::Get('Android'));
		
		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok') {
			return "succes send story quiz {$storydata['story_quizs']['id']}";
		}

		return false;				
	}	
}