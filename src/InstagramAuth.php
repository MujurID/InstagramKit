<?php namespace Riedayme\InstagramKit;

Class InstagramAuth
{

	public static function AuthUsingCookie($cookie)
	{

		$userid = InstagramCookie::GetUIDCookie($cookie);
		if (empty($userid)) die("cookie tidak valid");

		$userinfo = InstagramResourceUser::GetUserInfoByID($userid);

		$csrftoken = InstagramCookie::GetCSRFCookie($cookie);

		return [
			'userid' => $userid,
			'username' => $userinfo['username'], 
			'photo' => $userinfo['photo'],
			'cookie' => $cookie,
			'csrftoken' => $csrftoken
		];

	}

	public static function AuthUsingFacebookToken($data)
	{
		$data = str_replace(['view-source:','#'], '', $data);
		parse_str(parse_url($data, PHP_URL_QUERY), $output);;

		if (empty($output['access_token'])) {
			die("Data Tidak valid...");
		}

		$token = $output['access_token'];

		$fbid = InstagramResourceUser::GetFacebookID($token);

		$login = InstagramChecker::AccountConnectedWithFacebook($fbid,$token);

		if (!$login) {
			die("Facebook ini tidak terhubung dengan instagram !");
		}

		$cookie = InstagramCookie::ReadCookie($login['header']);
		$userinfo = InstagramResourceUser::GetUserInfoByFBToken($token);
		$csrftoken = InstagramCookie::GetCSRFCookie($cookie);
		$userid = $login['userid'];		
		// $userid = InstagramHelper::GetUserIDByAPI($userinfo['username'],$cookie);

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

		$cookiedata = InstagramCSRF::GetCSRFBySharedData();

		$password_enc = '#PWD_INSTAGRAM_BROWSER:0:' . time() . ':' . $password;

		$postdata = "username={$username}&enc_password={$password_enc}&queryParams=%7B%7D&optIntoOneTap=false";

		$headers = array();
		$headers[] = 'Referer: https://www.instagram.com/accounts/emailsignup/';
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$cookiedata['csrftoken'];
		$headers[] = "Cookie: ". $cookiedata['all'];

		$login = InstagramHelper::curl('https://www.instagram.com/accounts/login/ajax/', $postdata , $headers);
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