<?php namespace Riedayme\InstagramKit;

Class InstagramPostComment
{

	public $cookie;	
	public $csrftoken;

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}

	public function Process($postid,$text,$comment_id = false)
	{

		$url = "https://www.instagram.com/web/comments/{$postid}/add/";

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$postdata = 'comment_text='.$text.'&replied_to_comment_id='.$comment_id;

		$access = InstagramHelper::curl($url, $postdata , $headers);

		$response = json_decode($access['body'],true);
		
		if ($response['status'] == 'ok') {
			return [
				'status' => true,
				'response' => 'success send comment to post '.$postid.' message '. $text 
			];
		}else{
			return [
				'status' => false,
				'response' => $access['body']
			];
		}

	}

}