<?php namespace Riedayme\InstagramKit;

class InstagramUserAgent
{

	public static function Get($type = 'Windows')
	{

		if ($type == 'Windows') {
			return "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36";
		}
	}
}