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
}