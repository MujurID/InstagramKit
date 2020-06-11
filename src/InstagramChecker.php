<?php namespace Riedayme\InstagramKit;

Class InstagramChecker
{	
	public static function AccountConnectedWithFacebook($fbid,$token)
	{

		$url = 'https://www.instagram.com/accounts/login/ajax/facebook/';
		$postdata = "accessToken={$token}&fbUserId={$fbid}&queryParams=%7B%7D";

		$headers = array();
		$headers[] = "X-Csrftoken: ".InstagramCSRF::GetCSRFByAPI();

		$access = InstagramHelper::curl($url,$postdata,$headers);
		$header = $access['header'];
		$result = json_decode($access['body']);

		if ($result->status == 'fail') {
			return false;
		}		

		return [
			'userid' => $result->userId,
			'header' => $header 
		];
	}

	public static function CheckLiveCookie($data)
	{

		$url = 'https://i.instagram.com/api/v1/users/' . $data['username'] . '/usernameinfo';

		$headers = array();
		$headers[] = "Cookie: ".$data['cookie'];

		$useragent = InstagramUserAgent::Get('Windows');

		$access = InstagramHelper::curl($url, false , $headers, false, $useragent);

		$result = json_decode($access['body']);

		if ($result->status == 'ok') {
			return true;
		}

		return false;
	}

	public static function CheckLiveCookieV2($data){

		$url = 'https://www.instagram.com/'.$data['username'].'/?__a=1';

		$headers = array();
		$headers[] = "Cookie: ".$data['cookie'];

		$useragent = InstagramUserAgent::Get('Windows');

		$access = InstagramHelper::curl($url, false , $headers, false, $useragent);

		$result = json_decode($access['body']);

		if($result->graphql->user->restricted_by_viewer === false){
			return true;
		}

		return false;
	}	
}