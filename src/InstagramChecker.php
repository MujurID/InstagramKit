<?php namespace Riedayme\InstagramKit;

Class InstagramChecker
{	
	public static function AccountConnectedWithFacebook($token)
	{

		$fbid = InstagramResourceUser::GetFacebookID($token);

		$url = 'https://www.instagram.com/accounts/login/ajax/facebook/';
		$postdata = "accessToken={$token}&fbUserId={$fbid}&queryParams=%7B%7D";

		$headers = array();
		$headers[] = "X-Csrftoken: ".InstagramCSRF::GetCSRFBySharedData();

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

	public static function CheckLiveCookie($cookie){

		$userid = InstagramCookie::GetUIDCookie($cookie);
		if (empty($userid)) die("[ERROR] tidak dapat mengambil user id dari cookie");
		
		$userinfo = InstagramResourceUser::GetUserInfoByID($userid);
		
		$url = 'https://www.instagram.com/'.$userinfo['username'].'/?__a=1';

		$headers = array();
		$headers[] = "Cookie: ".$cookie;

		$useragent = InstagramUserAgent::Get('Windows');

		$access = InstagramHelper::curl($url, false , $headers, false, $useragent);

		$result = json_decode($access['body']);

		if($result->graphql->user->restricted_by_viewer === false){
			return [
			'userid' => $userid,
			'username' => $userinfo['username'],
			'photo' => $userinfo['photo']
			];
		}

		return false;
	}	
}