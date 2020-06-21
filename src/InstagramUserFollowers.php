<?php namespace Riedayme\InstagramKit;


Class InstagramUserFollowers
{

	public $cookie;	

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}

	public function Process($userid,$fetch_media_item_cursor = false)
	{

		if ($fetch_media_item_cursor) {
			$variables = '{"id":"'. $userid .'","include_reel":true,"fetch_mutual":false,"first":50,"after":"'. $fetch_media_item_cursor .'"}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=c76146de99bb02f6415203be841dd25a&variables='.urlencode($variables);
		}else{
			$variables = '{"id":"'. $userid .'","include_reel":true,"fetch_mutual":false,"first":50}';
			$url = 'https://www.instagram.com/graphql/query/?query_hash=c76146de99bb02f6415203be841dd25a&variables='.urlencode($variables);
		}

		$headers = array();
		$headers[] = "Cookie: ".$this->cookie;
		$headers[] = "X-Csrftoken: ".$this->csrftoken;

		$useragent = InstagramUserAgent::Get('Windows');

		$access = InstagramHelper::curl($url, false , $headers, false, $useragent);

		$response = json_decode($access['body'],true);

		if ($response['status'] != 'ok') {
			return false;
		}

		return $response;
	}

}