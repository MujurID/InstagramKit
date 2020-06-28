<?php namespace Riedayme\InstagramKit;

Class InstagramPostUploadPhoto
{

	public $cookie;	
	public $csrftoken;

	public $upload_id;
	public $results_UploadPhoto;
	public $result_CaptionPhoto;

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}
	
	public function Process($binary_file)
	{

		$upload_id = time();

		$url = "https://www.instagram.com/rupload_igphoto/fb_uploader_{$upload_id}";

		$postdata = file_get_contents($binary_file);

		$headers = array();
		$headers[] = 'Offset: 0';
		$headers[] = 'X-Entity-Name: fb_uploader_'.$upload_id;
		$headers[] = 'X-Instagram-Ajax:';
		$headers[] = 'Content-Type: image/jpeg';
		$headers[] = 'Accept: */*';
		$headers[] = 'X-Instagram-Rupload-Params: '.json_encode(array('media_type' => "1",'upload_id' => $upload_id));
		$headers[] = 'X-Entity-Length: '.strlen($binary_file);
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$access = InstagramHelper::curl($url, $postdata , $headers);

		$response = json_decode($access['body'],true);
		
		if ($response['status'] == 'ok') {
			return [
				'status' => true,
				'response' => [
					'upload_id' => $upload_id
				]
			];
		}else{
			return [
				'status' => false,
				'response' => $access['body']
			];
		}
	}

	public function Configure($upload_id,$caption)
	{

		$url = "https://www.instagram.com/create/configure/";

		$postdata = "upload_id={$upload_id}&caption={$caption}&usertags=&custom_accessibility_caption=&retry_timeout=";

		$headers = array();
		// $headers[] = 'X-Instagram-Ajax: 0661ce6986f2';
		$headers[] = "Content-Type: application/x-www-form-urlencoded";
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$access = InstagramHelper::curl($url, $postdata , $headers);

		$response = json_decode($access['body'],true);
		
		if ($response['status'] == 'ok') {
			return [
				'status' => true,
				'response' => [
					'id' => $response['media']['pk'],
					'code' => $response['media']['code'],
					'url' => "https://www.instagram.com/p/{$response['media']['code']}/"
				]
			];
		}else{
			return [
				'status' => false,
				'response' => $access['body']
			];
		}
	}

}