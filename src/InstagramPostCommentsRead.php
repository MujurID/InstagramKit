<?php namespace Riedayme\InstagramKit;


Class InstagramPostCommentsRead
{

	public $cookie;	

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}

	public function Process($shortcode,$fetch_media_item_cursor = false)
	{

		if ($fetch_media_item_cursor) {
			$variables = '{"shortcode":"'. $shortcode .'","first":35,"after":"'. $fetch_media_item_cursor .'"}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=bc3296d1ce80a24b1b6e40b1e72903f5&variables='.urlencode($variables);
		}else{
			$variables = '{"shortcode":"'. $shortcode .'","first":35,"after":""}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=bc3296d1ce80a24b1b6e40b1e72903f5&variables='.urlencode($variables);
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