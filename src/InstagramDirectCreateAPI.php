<?php namespace Riedayme\InstagramKit;

Class InstagramDirectCreateAPI
{

	public $cookie;	

	public function SetCookie($data) 
	{
		$this->cookie = $data;
	}

	public function Process($userids)
	{

		$url = "https://i.instagram.com/api/v1/direct_v2/create_group_thread/";

		$data = json_encode([
			'recipient_users'   => json_encode($userids)
		]);

		$buildpostdata = InstagramHelperAPI::generateSignature($data);

		$access = InstagramHelperAPI::curl($url, $buildpostdata , false , $this->cookie , InstagramUserAgent::Get('Android'));

		$response = json_decode($access['body'],true);
		
		if ($response['status'] == 'ok') {
			return [
				'status' => true,
				'response' => [
					'thread_id' => $response['thread_id']
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