<?php namespace Riedayme\InstagramKit;

Class InstagramUserFollowersAPI
{

	public $cookie;	

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

		if ($response['status'] == 'ok' AND $response['users'] != null) {		

			$next_id = $response['next_max_id'];

			return [
				'status' => true,
				'response' => $response,
				'next_id' => $next_id
			];

		}else{

			if ($response['status'] == 'ok') {

				return [
					'status' => false,
					'response' => 'no_followers'
				];
			}

			return [
				'status' => false,
				'response' => $access['body']
			];
		}	
	}

	public function Extract($response){

		if (!$response['status']) return $response;

		$jsondata = $response['response'];

		$extract = array();
		foreach ($jsondata['users'] as $key => $user) {

			$extract[] = [
				'userid' => $user['pk'],
				'username' => $user['username'],
				'photo' => $user['profile_pic_url'],
				'is_private' => $user['is_private'],
				'latest_reel_media' => $user['latest_reel_media'],
			];

		}

		return $extract;
	}

}