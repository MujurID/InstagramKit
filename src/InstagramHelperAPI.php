<?php namespace Riedayme\InstagramKit;

Class InstagramHelperAPI
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
			curl_setopt($ch, CURLOPT_COOKIE, $cookie);
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
	
	public static function generateDeviceId($seed)
	{
		$volatile_seed = filemtime(__DIR__);
		return 'android-'.substr(md5($seed.$volatile_seed), 16);
	}

	public static function generateSignature($data)
	{
		// ac129560d96023898d85aff6ee861218ff504ab34848a09747a3f0987439de0f
		$hash = hash_hmac('sha256', $data, 'b4946d296abf005163e72346a6d33dd083cadde638e6ad9c5eb92e381b35784a');
		return 'ig_sig_key_version=4&signed_body='.$hash.'.'.urlencode($data);
	}

	public static function generateSignature_Upload($data)
	{
		$hash = hash_hmac('sha256', $data, '5ad7d6f013666cc93c88fc8af940348bd067b68f0dce3c85122a923f4f74b251');

		return 'ig_sig_key_version=4&signed_body='.$hash.'.'.urlencode($data);
	}

	public static function generateUUID($type)
	{
		$uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand(0, 0xffff), mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),
			mt_rand(0, 0x0fff) | 0x4000,
			mt_rand(0, 0x3fff) | 0x8000,
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
			);

		return $type ? $uuid : str_replace('-', '', $uuid);
	}

}