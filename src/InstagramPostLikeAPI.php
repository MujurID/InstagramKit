<?php namespace Riedayme\InstagramKit;

Class InstagramPostLikeAPI
{

	public $cookie;	

	public function SetCookie($data) 
	{
		$this->cookie = $data;
	}

	public function Process($postdata)
	{

		$url = "https://i.instagram.com/api/v1/media/{$postdata['id']}/like/";

		$data = json_encode([
			'_uuid'      => $this->uuid,
			'_uid'       => $this->uid,
			'_csrftoken' => $this->token,
			'media_id'   => $postdata['id']
			]);

		$buildpostdata = InstagramHelperAPI::generateSignature($data);

		$access = InstagramHelperAPI::curl($url, $buildpostdata , false , $this->cookie , InstagramUserAgent::Get('Android'));

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