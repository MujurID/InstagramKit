<?php namespace Riedayme\InstagramKit;

Class InstagramPostLike
{

	public $cookie;	
	public $csrftoken;

	public function SetCookie($data) 
	{
		$this->cookie = $data;
	}

	public function SetCSRF($data) 
	{
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}

	public function Process($postdata)
	{

		$url = "https://www.instagram.com/web/likes/{$postdata['id']}/like/";

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$access = InstagramHelper::curl($url, 'empty' , $headers);

		$response = json_decode($access['body'],true);
		
		if ($response['status'] == 'ok') {
			return [
			'status' => true,
			'id' => $postdata['id']
			];
		}else{
			return false;
		}

	}

}