<?php namespace Riedayme\InstagramKit;

class InstagramUserAgent
{

	public static function Get($type = 'Windows')
	{

		if ($type == 'Windows') {
			return "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36";
		}elseif ($type == 'Android') {

			return 'Instagram 115.0.0.26.111 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)';

			// return 'Instagram 76.0.0.15.395 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)';
			
			// $data = [
			// 'Instagram 9.6.0 Android (19/4.4.2; 480dpi; 1080x1920; samsung; SM-N900T; hltetmo; qcom; en_US)',
			// 'Instagram 12.0.0.7.91 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US',
			// 'Instagram 76.0.0.15.395 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)'
			// ];
			
			// return $data[array_rand($data)];
		}
	}
}