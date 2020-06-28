<?php namespace Riedayme\InstagramKit;

Class InstagramSeenStory
{

	public $cookie;	
	public $csrftoken;

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}

	public function Process($postdata)
	{

		$url = 'https://www.instagram.com/stories/reel/seen';

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$time = time();
		$sendpost = "reelMediaId={$postdata['id']}&reelMediaOwnerId={$postdata['userid']}&reelId={$postdata['userid']}&reelMediaTakenAt={$postdata['taken_at']}&viewSeenAt={$time}";

		$access = InstagramHelper::curl($url, $sendpost , $headers);

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok') {
			return [
				'status' => true,
				'response' => 'success seen story '.$postdata['id']
			];
		}else{
			return [
				'status' => false,
				'response' => $access['body']
			];
		}
	}		
}