<?php namespace Riedayme\InstagramKit;

Class InstagramPostLikeAPI
{

	public $cookie;	

	public function SetCookie($data) 
	{
		$this->cookie = $data;
	}

	public function Process($postid)
	{

		$url = "https://i.instagram.com/api/v1/media/{$postid}/like/";

		$data = json_encode([
			'media_id'   => $postid
		]);

		$buildpostdata = InstagramHelperAPI::generateSignature($data);

		$access = InstagramHelperAPI::curl($url, $buildpostdata , false , $this->cookie , InstagramUserAgent::Get('Android'));

		$response = json_decode($access['body'],true);
		
		if ($response['status'] == 'ok') {
			return [
				'status' => true,
				'response' => 'success like post '.$postid
			];
		}else{
			return [
				'status' => false,
				'response' => $access['body']
			];
		}

	}

}