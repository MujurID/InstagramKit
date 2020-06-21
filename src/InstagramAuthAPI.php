<?php namespace Riedayme\InstagramKit;

Class InstagramAuthAPI
{

	public function Login($username,$password)
	{

		$url = 'https://i.instagram.com/api/v1/accounts/login/';

		$guid = InstagramHelperAPI::generateUUID(true);

		$data = [
			'device_id'           => InstagramHelperAPI::generateDeviceId(md5($username.$password)),
			'guid'                => $guid,
			'phone_id'            => InstagramHelperAPI::generateUUID(true),
			'username'            => $username,
			'password'            => $password,
			'login_attempt_count' => '0',
		];

		$postdata = InstagramHelperAPI::generateSignature(json_encode($data));

		$headers = [
			'Connection: close',
			'Accept: */*',
			'Content-type: application/x-www-form-urlencoded; charset=UTF-8',
			'Cookie2: $Version=1',
			'Accept-Language: en-US',
		];

		$login = InstagramHelper::curl($url, $postdata , false , false, InstagramUserAgent::Get('Android'));

		$response = json_decode($login['body'],true);

		if($response['status'] == 'ok') {

			$userid = $response['logged_in_user']['pk'];
			$userinfo = InstagramResourceUser::GetUserInfoByID($userid);			
			$rank_token = $userid.'_'.$guid;

			$cookie = InstagramCookie::ReadCookie($login['header']);
			$csrftoken = InstagramCookie::GetCSRFCookie($cookie);

			return [
				'userid' => $userid,
				'username' => $userinfo['username'], 
				'photo' => $userinfo['photo'],
				'cookie' => $cookie,
				'csrftoken' => $csrftoken,
				'uuid' => $guid,
				'rank_token' => $rank_token
			];

		}elseif ($response['error_type'] == 'checkpoint_challenge_required') {

			$required['response'] = 'checkpoint';
			$required['url'] = $response['challenge']['url'];
			$required['cookie'] = InstagramCookie::ReadCookie($login['header']);
			$required['csrftoken'] = InstagramCookie::GetCSRFCookie($required['cookie']);
			$required['guid'] = $guid;

			return $required;
		}

		die($response['message']);
	}

	public function CheckPointSend($postdata,$choice = 1)
	{
		$url = $postdata['url'];

		$sendpost = "choice={$choice}";

		$headers = [
			'Connection: keep-alive',
			'Proxy-Connection: keep-alive',
			'Accept-Language: en-US,en',
			'x-csrftoken: '.$postdata['csrftoken'],
			'x-instagram-ajax: 1',
			'Referer: '.$url,
			'x-requested-with: XMLHttpRequest',
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
		];

		$access = InstagramHelperAPI::curl($url, $sendpost , $headers , $postdata['cookie'], InstagramUserAgent::Get('Android'));

		$response = json_decode($access['body'],true);

		return $response;
	}

	public function CheckPointSolve($postdata)
	{
		$url = $postdata['url'];

		$sendpost = "security_code={$postdata['security_code']}";

		$headers = [
			'Connection: keep-alive',
			'Proxy-Connection: keep-alive',
			'Accept-Language: en-US,en',
			'x-csrftoken: '.$postdata['csrftoken'],
			'x-instagram-ajax: 1',
			'Referer: '.$url,
			'x-requested-with: XMLHttpRequest',
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
		];

		$access = InstagramHelperAPI::curl($url, $sendpost , $headers , $postdata['cookie'], InstagramUserAgent::Get('Android'));

		$response = json_decode($access['body'],true);

		if($response['status'] == 'ok') {

			$cookie = InstagramCookie::ReadCookie($access['header']);

			$check_cookie = InstagramChecker::CheckLiveCookie($cookie);
			if (!$check_cookie) die("[ERROR] cookie tidak bisa digunakan".PHP_EOL);

			$csrftoken = InstagramCookie::GetCSRFCookie($cookie);

			$rank_token = $check_cookie['userid'].'_'.$postdata['guid'];

			return [
				'userid' => $check_cookie['userid'],
				'username' => $check_cookie['username'], 
				'photo' => $check_cookie['photo'],
				'cookie' => $cookie,
				'csrftoken' => $csrftoken,
				'uuid' =>$postdata['guid'],
				'rank_token' => $rank_token
			];
		}

		return $access['body'];
	}	

}