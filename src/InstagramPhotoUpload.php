<?php namespace Riedayme\InstagramKit;
Class InstagramPhotoUpload
{

	public $upload_id;
	public $cookie;	
	public $csrftoken;
	public $results_UploadPhoto;
	public $result_CaptionPhoto;

	function __construct()
	{
		self::SetUploadId();
	}

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}
	
	public function UploadPhoto($binary_file)
	{

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://www.instagram.com/rupload_igphoto/fb_uploader_'.$this->upload_id);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, self::ReadPhoto($binary_file));

		$headers = array();
		$headers[] = 'Authority: www.instagram.com';
		// $headers[] = 'X-Ig-Www-Claim: hmac.AR2sQMxsgNFPzh-C8AImL3f8L68GuOzLVAEn7wXHAeEcnNC1';
		$headers[] = 'Offset: 0';
		$headers[] = 'X-Entity-Name: fb_uploader_'.$this->upload_id;
		// $headers[] = 'X-Instagram-Ajax: 0661ce6986f2';
		$headers[] = 'Content-Type: image/jpeg';
		$headers[] = 'Accept: */*';
		$headers[] = 'X-Instagram-Rupload-Params: '.json_encode(array('media_type' => "1",'upload_id' => $this->upload_id));
		// $headers[] = 'X-Requested-With: XMLHttpRequest';
		$headers[] = 'X-Entity-Length: '.strlen($binary_file);
		$headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Mobile Safari/537.36';
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		// $headers[] = 'X-Ig-App-Id: 1217981644879628';
		// $headers[] = 'Origin: https://www.instagram.com';
		// $headers[] = 'Sec-Fetch-Site: same-origin';
		// $headers[] = 'Sec-Fetch-Mode: cors';
		// $headers[] = 'Sec-Fetch-Dest: empty';
		// $headers[] = 'Referer: https://www.instagram.com/create/details/';
		// $headers[] = 'Accept-Language: en-US,en;q=0.9,id;q=0.8';
		$headers[] = "Cookie: ".$this->cookie;
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$this->results_UploadPhoto = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
	}

	public function CaptionPhoto($caption)
	{

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://www.instagram.com/create/configure/');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "upload_id={$this->upload_id}&caption={$caption}&usertags=&custom_accessibility_caption=&retry_timeout=");
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

		$headers = array();
		// $headers[] = 'Authority: www.instagram.com';
		// $headers[] = 'X-Ig-Www-Claim: hmac.AR2sQMxsgNFPzh-C8AImL3f8L68GuOzLVAEn7wXHAeEcnOjz';
		// $headers[] = 'X-Instagram-Ajax: 0661ce6986f2';
		$headers[] = "Content-Type: application/x-www-form-urlencoded";
		// $headers[] = 'Accept: */*';
		$headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Mobile Safari/537.36';
		// $headers[] = 'X-Requested-With: XMLHttpRequest';
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		// $headers[] = 'X-Ig-App-Id: 1217981644879628';
		// $headers[] = 'Origin: https://www.instagram.com';
		// $headers[] = 'Sec-Fetch-Site: same-origin';
		// $headers[] = 'Sec-Fetch-Mode: cors';
		// $headers[] = 'Sec-Fetch-Dest: empty';
		// $headers[] = 'Referer: https://www.instagram.com/create/details/';
		// $headers[] = 'Accept-Language: en-US,en;q=0.9,id;q=0.8';
		$headers[] = "Cookie: ".$this->cookie;
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$this->result_CaptionPhoto = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
	}

	public function SetUploadId()
	{
		$this->upload_id =  time();
	}

	public function ReadPhoto($image)
	{
		return file_get_contents($image);
	}

	public function Results()
	{

		$results_UploadPhoto = json_decode($this->results_UploadPhoto);		
		$result_CaptionPhoto = json_decode($this->result_CaptionPhoto);

		if ($results_UploadPhoto->status == 'ok') {
			$status_upload = 'success';
		}else {
			$status_upload = 'failed';
		}

		if ($result_CaptionPhoto->status == 'ok') {
			$status_caption = 'success';
			$id = $result_CaptionPhoto->media->pk;
			$code = $result_CaptionPhoto->media->code;
			$url = "https://www.instagram.com/p/{$code}/";			
		}else {
			$status_caption = 'failed';
		}		

		return [
		'UploadPhoto' => $status_upload,
		'CaptionPhoto' => $status_caption,
		'DataUpload' => [
		'id' => $id,
		'code' => $code,
		'url' => $url
		]
		];
	}

}