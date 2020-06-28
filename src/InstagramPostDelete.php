<?php namespace Riedayme\InstagramKit;

Class InstagramPostDelete
{

	public $cookie;	
	public $csrftoken;

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}

	public function Process($postid)
	{

		$url = "https://www.instagram.com/create/{$postid}/delete/";

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$access = InstagramHelper::curl($url, 'empty', $headers);

		$response = json_decode($access['body'],true);
		
		if ($response['status'] == 'ok') {
			return [
				'status' => true,
				'response' => 'success delete post '.$postid
			];
		}else{
			return [
				'status' => false,
				'response' => $access['body']
			];
		}

	}

}