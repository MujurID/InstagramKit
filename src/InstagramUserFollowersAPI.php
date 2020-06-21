<?php namespace Riedayme\InstagramKit;

Class InstagramUserFollowersAPI
{

	public $cookie;	

	public $results = array();

	public function SetCookie($data) 
	{
		$this->cookie = $data;
	}

	public function Process($userid,$next_max_id = false)
	{

		$parameters = ''; 
		if($next_max_id == true) { 
			$parameters = '?max_id='.$next_max_id; 
		}

		$url = 'https://i.instagram.com/api/v1/friendships/'.$userid.'/followers/'.$parameters;

		$access = InstagramHelperAPI::curl($url, false , false, $this->cookie, InstagramUserAgent::Get('Android'));

		$response = json_decode($access['body'],true);

		if ($response['status'] != 'ok') {
			return false;
		}

		return $response;	
	}

}