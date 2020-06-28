<?php namespace Riedayme\InstagramKit;


Class InstagramUserUnFollow
{

	public $cookie;	

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}

	public function Process($userid)
	{

		$url = "https://www.instagram.com/web/friendships/{$userid}/unfollow/";

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;
		$headers[] = 'X-Instagram-Ajax: ';

		$access = InstagramHelper::curl($url, 'empty' , $headers);

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok') {
			return [
				'status' => true,
				'response' => 'success_unfollow',
			];
		}else{
			return [
				'status' => false,
				'response' => $access['body']
			];
		}
	}

}