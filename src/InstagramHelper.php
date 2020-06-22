<?php namespace Riedayme\InstagramKit;

Class InstagramHelper
{

	public static function curl($url, $postdata = 0, $header = 0, $cookie = 0, $useragent = 0) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, false);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		if($header) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_ENCODING, "gzip");
		}
		if($postdata) {
			curl_setopt($ch, CURLOPT_POST, 1);
			if ($postdata != 'empty') {
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			}
		}

		if($cookie) {
			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		}
		if ($useragent) {
			curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		}

		$response = curl_exec($ch);
		$httpcode = curl_getinfo($ch);
		if(!$httpcode) {
			curl_close($ch);	
			die("Response header not found"); 
		}
		else{

			$header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
			$body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));

			curl_close($ch);

			return [
			'header' => $header,
			'body' => $body
			];
		}
	}	

	public static function FindStringOnArray($arr, $string) {
		return array_filter($arr, function($value) use ($string) {
			return strpos($value, $string) !== false;
		});
	}

	public static function GetStringBetween($string,$start,$end){
		$str = explode($start,$string);
		if (empty($str[1])) return false;
		$str = explode($end,$str[1]);
		return $str[0];
	}

	public static function ParseAccessToken($data)
	{
		$data = str_replace(['view-source:','#'], '', $data);
		parse_str(parse_url($data, PHP_URL_QUERY), $output);;

		if (empty($output['access_token'])) {
			die("[ERROR] Token tidak ditemukan");
		}

		$token = $output['access_token'];

		return $token;
	}

	public static function GetSleepTimeByLimit($limit){

		$dayinseconds = 86400;

		$sleep = $dayinseconds/$limit;

		return ceil($sleep);
	}

}