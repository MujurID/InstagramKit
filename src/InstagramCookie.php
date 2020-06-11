<?php namespace Riedayme\InstagramKit;

/**
 * Handling Cookie
 */
Class InstagramCookie
{
	public static function GetCSRFCookie($cookies){
		$cookies_to_arr = explode(';', $cookies);
		$result = InstagramHelper::FindStringOnArray($cookies_to_arr, 'csrftoken');
		if (count($result) > 1) {
			$result = array_slice($result, 1);
		}
		$result_csrftoken = implode("", $result);
		$csrftoken = substr(trim($result_csrftoken), 10);
		return $csrftoken;
	}

	public static function ReadCookie($response) 
	{
		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $results);
		$cookies = '';
		for($o = 0; $o < count($results[0]); $o++){
			$cookies.=$results[1][$o].";";
		}

		if (!$cookies) die("Cookie Tidak bisa diambil, kesalahan pada kode.");
		$search  = ['target="";'];

		return str_replace($search,'', $cookies);
	}

	public static function GetUIDCookie($cookies){
		$cookies_to_arr = explode(';', $cookies);
		$result = InstagramHelper::FindStringOnArray($cookies_to_arr, 'ds_user_id');
		if (count($result) > 1) {
			$result = array_slice($result, 1);
		}
		$result_userid = implode("", $result);
		$userid = substr(trim($result_userid), 11);
		return $userid;
	}

	public static function ReadEditThisCookie($data)
	{
		$cookies = '';
		foreach (json_decode($data,TRUE) as $read) {
			$cookies .= "{$read['name']}={$read['value']};";
		}

		return $cookies;
	}

}
