<?php namespace Riedayme\InstagramKit;

Class InstagramCSRF
{

	public static function GetCSRFBySharedData()
	{
		$fetch = InstagramHelper::curl('https://www.instagram.com/data/shared_data/');
		$header = $fetch['header'];

		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $header, $matches);

		$cookies = array();
		foreach($matches[1] as $item) {
			parse_str($item, $cookie);
			$cookies = array_merge($cookies, $cookie);
		}

		$buildcookie = '';
		foreach ($cookies as $key => $read) {
			$buildcookie .= "{$key}={$read};";
		}

		return [
			'csrftoken' => $cookies['csrftoken'],
			'all' => $buildcookie
		];
	}

	/**
	 * CSRF Token
	 */
	public static function GetCSRFByAPI()
	{
		$fetch = InstagramHelper::curl('https://i.instagram.com/api/v1/si/fetch_headers/?challenge_type=signup');
		$header = $fetch['header'];

		if (!preg_match('/^Set-Cookie:\s*([^;]*)/mi', $header, $token)) {
			die("[ERROR] Tidak ditemukan csrftoken");
		} else {
			return substr($token[0], 22);
		}
	}
}