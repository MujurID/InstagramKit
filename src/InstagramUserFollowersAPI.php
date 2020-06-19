<?php namespace Riedayme\InstagramKit;

Class InstagramUserFollowersAPI
{

	public $cookie;	

	public $results;

	public function SetCookie($data) 
	{
		$this->cookie = $data;
	}

	public function Process($postdata,$next_max_id = false)
	{

		$parameters = ''; 
		if($next_max_id == true) { 
			$parameters = '?max_id='.$next_max_id; 
		}

		$url = 'https://i.instagram.com/api/v1/friendships/'.$postdata['userid'].'/followers/'.$parameters;

		$access = InstagramHelperAPI::curl($url, false , false, $this->cookie, InstagramUserAgent::Get('Android'));

		$userlist = json_decode($access['body'],true);

		// echo $access['body'];

		if ($userlist['status'] != 'ok') {
			return false;
		}

		if ($postdata['extract_type'] == 'story') {
			foreach ($userlist['users'] as $key => $user) {

				if($user['is_private']) continue;
				if(!$user['latest_reel_media']) continue;

				$this->results[] = [
				'userid' => $user['pk'],
				'username' => $user['username'],
				'is_private' => $user['is_private'],
				'photo' => $user['profile_pic_url'],
				'latest_reel_media' => $user['latest_reel_media']			
				];

				if (count($this->results) >= $postdata['limit']) break;
			}
		}

		if (count($this->results) <= $postdata['limit'] AND $userlist['next_max_id']) {
			return self::Process($postdata,$userlist['next_max_id']);
		}

		return $this->results;		
	}

}