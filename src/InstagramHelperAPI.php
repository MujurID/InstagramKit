<?php namespace Riedayme\InstagramKit;

Class InstagramHelperAPI
{

	public static function generateDeviceId($seed)
	{
		$volatile_seed = filemtime(__DIR__);
		return 'android-'.substr(md5($seed.$volatile_seed), 16);
	}

	public static function generateSignature($data)
	{
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