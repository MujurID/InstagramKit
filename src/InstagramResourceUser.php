<?php namespace Riedayme\InstagramKit;

/**
* Get User Info
*/
Class InstagramResourceUser
{

	public static function GetUserInfoByID($userid)
	{
		// 7c8a1055f69ff97dc201e752cf6f0093

		$url = 'https://www.instagram.com/graphql/query/?query_hash=7c16654f22c819fb63d1183034a5162f&variables=%7B%22user_id%22%3A%22'.$userid.'%22%2C%22include_chaining%22%3Atrue%2C%22include_reel%22%3Atrue%2C%22include_suggested_users%22%3Afalse%2C%22include_logged_out_extras%22%3Afalse%2C%22include_highlight_reels%22%3Afalse%7D';

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$access = InstagramHelper::curl($url, false, $headers);

		$result = json_decode($access['body']);

		if ($result->status == 'ok') {

			if ($result->data->user != null) {
				$username = $result->data->user->reel->owner->username;
				$photo = $result->data->user->reel->owner->profile_pic_url;

				return [
					'username' => $username,
					'photo' => $photo
				];
			}else{
				die("tidak ditemukan data untuk userid : {$userid}");
			}
		}else{
			die($access['body']);
		}
	}

	public static function GetUserIDByAPI($username,$cookie)
	{


		$url = 'https://i.instagram.com/api/v1/users/' . $username . '/usernameinfo';

		$headers = array();
		$headers[] = "X-Csrftoken: ".InstagramCSRF::GetCSRFByAPI();
		$headers[] = "Cookie: ".$cookie;

		$useragent = InstagramUserAgent::Get('Windows');

		$access = InstagramHelper::curl($url, false , $headers, false, $useragent);

		$result = json_decode($access['body']);

		if ($result->status != 'ok') {
			die("Ada Kesalahan pada proses");
		}

		return $result->user->pk;	
	}

	public static function GetUserInfoByFBToken($token)
	{

		$url = 'https://www.instagram.com/accounts/fb_profile/';
		$postdata = "accessToken={$token}";

		$headers = array();
		$headers[] = "X-Csrftoken: ".InstagramCSRF::GetCSRFByAPI();

		$access = InstagramHelper::curl($url , $postdata , $headers );

		$result = json_decode($access['body']);

		if ($result->status == 'fail') {
			die("Token tidak valid.");
		}

		$username = $result->igAccount->username;
		$photo = $result->igAccount->profilePictureUrl;		

		return [
			'username' => $username,
			'photo' => $photo
		];
	}

	public static function GetFacebookID($token)
	{
		$access = InstagramHelper::curl("https://graph.facebook.com/me?fields=name,picture&access_token={$token}");
		$response = json_decode($access['body']);
		if (strpos($access['header'],'HTTP/2 400') !== false) {
			die($response->error->message);
		}	

		return $response->id;
	}
}