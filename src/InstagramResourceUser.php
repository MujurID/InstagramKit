<?php namespace Riedayme\InstagramKit;

Class InstagramResourceUser
{

	public static function GetUserInfoByID($userid)
	{
		
		$url = 'https://www.instagram.com/graphql/query/?query_hash=7c16654f22c819fb63d1183034a5162f&variables={"user_id":"'.$userid.'","include_chaining":false,"include_reel":true,"include_suggested_users":false,"include_logged_out_extras":false,"include_highlight_reels":false}';

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
		if (strpos($access['header'],'400 Bad Request') !== false) {
			die($response->error->message);
		}	

		return $response->id;
	}

	public static function GetCurrentUserInfoByAPI($cookie){

		$url = 'https://i.instagram.com/api/v1/accounts/current_user/';

		$useragent = InstagramUserAgent::Get('Android');

		$access = InstagramHelperAPI::curl($url, false , false, $cookie, $useragent);

		return json_decode($access['body'],true);
	}

	public static function GetUserInfoByAPI($cookie){

		$userid = InstagramCookie::GetUIDCookie($cookie);
		if (empty($userid)) die("[ERROR] tidak dapat mengambil user id dari cookie");

		$url = 'https://i.instagram.com/api/v1/users/' . $userid . '/info/';

		$useragent = InstagramUserAgent::Get('Android');

		$access = InstagramHelperAPI::curl($url, false , false, $cookie, $useragent);

		return json_decode($access['body'],true);
	}	

	public static function GetUsernameInfoByAPI($cookie,$username)
	{

		$url = 'https://i.instagram.com/api/v1/users/' . $username . '/usernameinfo';

		$useragent = InstagramUserAgent::Get('Android');

		$access = InstagramHelperAPI::curl($url, false , false, $cookie, $useragent);

		return json_decode($access['body'],true);
	}

	public static function GetUserIdByAPI($cookie,$username)
	{

		$url = 'https://i.instagram.com/api/v1/users/' . $username . '/usernameinfo';

		$useragent = InstagramUserAgent::Get('Android');

		$access = InstagramHelperAPI::curl($url, false , false, $cookie, $useragent);

		$response = json_decode($access['body'],true);

		$userid = $response['user']['pk'];

		return $userid;
	}	

	public function GetUserIdByScraping($username)
	{
		$url      = "https://www.instagram.com/" . $username;
		$html     = file_get_contents($url);
		$arr      = explode('window._sharedData = ', $html);
		$arr      = explode(';</script>', $arr[1]);
		$obj      = json_decode($arr[0], true);
		$id       = $obj['entry_data']['ProfilePage'][0]['graphql']['user']['id'];

		return $id;
	}

	public static function GetUserIdByWeb($username){
		
		$url = 'https://www.instagram.com/'.$username.'/?__a=1';

		$useragent = InstagramUserAgent::Get('Windows');

		$access = InstagramHelper::curl($url, false , false, false, $useragent);

		$result = json_decode($access['body'],true);

		if(is_array($result)){
			return $result['graphql']['user']['id'];
		}

		return false;
	}

}