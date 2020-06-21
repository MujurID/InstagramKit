<?php namespace Riedayme\InstagramKit;


Class InstagramPostCommentsReplyRead
{

	public $cookie;	

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}

	public function Process($commentid,$fetch_media_item_cursor = false)
	{

		if ($fetch_media_item_cursor) {
			$variables = '{"comment_id":"'. $commentid .'","first":35,"after":"'. $fetch_media_item_cursor .'"}';			
			$url = 'https://www.instagram.com/graphql/query/?query_hash=1ee91c32fc020d44158a3192eda98247&variables='.urlencode($variables);
		}else{
			$variables = '{"comment_id":"'. $commentid .'","first":35,"after":""}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=1ee91c32fc020d44158a3192eda98247&variables='.urlencode($variables);
		}

		$headers = array();
		$headers[] = "Cookie: ".$this->cookie;
		$headers[] = "X-Csrftoken: ".$this->csrftoken;

		$useragent = InstagramUserAgent::Get('Windows');

		$access = InstagramHelper::curl($url, false , $headers, false, $useragent);

		// echo $access['body'];
		// exit;
		
		$response = json_decode($access['body'],true);

		if ($response['status'] != 'ok') {
			return false;
		}

		return $response;
	}

}