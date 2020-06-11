<?php namespace Riedayme\InstagramKit;

Class InstagramPostDelete
{

	public $cookie;	
	public $csrftoken;

	public function SetCookie($data) 
	{
		$this->cookie = $data;
	}

	public function SetCSRF($data) 
	{
		$this->csrftoken = $data;
	}

	public function Process($postdata)
	{

		$success = array();
		$failed = array();		
		foreach ($postdata as $key => $post) {

			$url = "https://www.instagram.com/create/{$post}/delete/";

			$headers = array();
			$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
			$headers[] = "X-Csrftoken: ".$this->csrftoken;
			$headers[] = "Cookie: ". $this->cookie;

			$access = InstagramHelper::curl($url, 'empty', $headers);

			$response = json_decode($access['body']);

			if ($response->status != 'ok') {
				$failed[] = $post;
			}else{
				$success[] = $post;
			}
		}

		return [
			'success' => count($success),
			'failed' => count($failed)
		];
	}

}