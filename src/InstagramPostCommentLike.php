<?php namespace Riedayme\InstagramKit;

Class InstagramPostCommentLike
{

	public $cookie;	
	public $csrftoken;

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}

	public function Process($commentid)
	{

		$url = "https://www.instagram.com/web/comments/like/{$commentid}/";

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$access = InstagramHelper::curl($url, 'empty' , $headers);

		$response = json_decode($access['body'],true);
		
		if ($response['status'] == 'ok') {
			return [
			'status' => true,
			'response' => 'success like comment '.$commentid
			];
		}else{
			return [
			'status' => false,
			'response' => $access['body']
			];
		}

	}

}