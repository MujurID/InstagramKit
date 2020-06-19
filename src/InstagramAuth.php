<?php namespace Riedayme\InstagramKit;

Class InstagramAuth
{

	public static function AuthUsingCookie($cookie)
	{

		$check_cookie = InstagramChecker::CheckLiveCookie($cookie);
		if (!$check_cookie) die("[ERROR] cookie tidak bisa digunakan".PHP_EOL);

		$csrftoken = InstagramCookie::GetCSRFCookie($cookie);

		return [
		'userid' => $check_cookie['userid'],
		'username' => $check_cookie['username'], 
		'photo' => $check_cookie['photo'],
		'cookie' => $cookie,
		'csrftoken' => $csrftoken
		];

	}

	public static function AuthUsingFacebookToken($data)
	{

		$token = InstagramHelper::ParseAccessToken($data);

		$login = InstagramChecker::AccountConnectedWithFacebook($token);

		if (!$login) {
			die("[ERROR] Akun facebook tidak terhubung dengan instagram");
		}

		$cookie = InstagramCookie::ReadCookie($login['header']);
		$userinfo = InstagramResourceUser::GetUserInfoByFBToken($token);
		$csrftoken = InstagramCookie::GetCSRFCookie($cookie);
		$userid = $login['userid'];		

		return [
		'userid' => $userid,
		'username' => $userinfo['username'], 
		'photo' => $userinfo['photo'],
		'cookie' => $cookie,
		'csrftoken' => $csrftoken
		];
	}

	public static function AuthLoginByWebAjax($username,$password) 
	{

		$url = 'https://www.instagram.com/accounts/login/ajax/';

		$password_enc = '#PWD_INSTAGRAM_BROWSER:0:' . time() . ':' . $password;

		$postdata = "username={$username}&enc_password={$password_enc}&queryParams=%7B%7D&optIntoOneTap=false";

		$cookiedata = InstagramCSRF::GetCSRFBySharedData();

		$headers = array();
		$headers[] = 'Referer: https://www.instagram.com/accounts/emailsignup/';
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$cookiedata['csrftoken'];
		$headers[] = "Cookie: ". $cookiedata['all'];

		$login = InstagramHelper::curl($url, $postdata , $headers);
		$result = json_decode($login['body']);

		if (is_null($result)) {
			die($result);
		}

		if($result->authenticated == true)
		{

			$cookie = InstagramCookie::ReadCookie($login['header']);
			$csrftoken = InstagramCookie::GetCSRFCookie($cookie);
			$userid = $result->userId;
			$userinfo = InstagramResourceUser::GetUserInfoByID($userid);

			return [
			'userid' => $userid,
			'username' => $userinfo['username'], 
			'photo' => $userinfo['photo'],
			'cookie' => $cookie,
			'csrftoken' => $csrftoken
			];

		}else{
			if ($result->user == true) {
				die("Password salah");
			}else {
				die("Username tidak ditemukan, bisa juga kesalahan pada kode");
			}
		}
	}

	public static function AuthLoginByAPI($username,$password)
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

			$url = $response['challenge']['url'];

			$cookie = InstagramCookie::ReadCookie($login['header']);
			$csrftoken = InstagramCookie::GetCSRFCookie($cookie);

			$postdata = "choice=2";

			$headers = [
			'Connection: keep-alive',
			'Proxy-Connection: keep-alive',
			'Accept-Language: en-US,en',
			'x-csrftoken: '.$csrftoken,
			'x-instagram-ajax: 1',
			'Referer: '.$url,
			'x-requested-with: XMLHttpRequest',
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
			];

			$access = InstagramHelperAPI::curl($url, $postdata , $headers , $cookie, InstagramUserAgent::Get('Android'));

			echo $access['body'];

			exit;
		}

		die($response['message']);
	}

}