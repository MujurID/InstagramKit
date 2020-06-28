<?php namespace Riedayme\InstagramKit;

Class InstagramFeedStory
{

	public $cookie;	
	public $csrftoken;

	public $query_hash;	

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
		$this->query_hash = self::GetQueyHash();
	}

	public function GetQueyHash()
	{

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$access = InstagramHelper::curl('https://www.instagram.com/', false, $headers);

		$response =  $access['body'];

		preg_match('/query_hash=([^\s]+)/', $response, $matches);

		if (!empty($matches)) {
			$query_hash = explode('=',$matches[0]);
			$query_hash = explode('&amp',$query_hash[1]);
			$query_hash = $query_hash[0];

			return $query_hash;
		}else{
			return false;
		}
	}	

	public function Process()
	{

		if (!$this->query_hash) {
			return [
				'status' => false,
				'response' => 'error_query_hash'
			];
		}

		$url = 'https://www.instagram.com/graphql/query/?query_hash='.$this->query_hash.'&variables=%7B%7D';

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$access = InstagramHelper::curl($url, false , $headers);

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok' AND $response['data']['user']['feed_reels_tray']['edge_reels_tray_to_reel']['edges'] != null) {		

			return [
				'status' => true,
				'response' => $response
			];

		}else{

			if ($response['status'] == 'ok') {

				return [
					'status' => false,
					'response' => 'no_story'
				];
			}

			return [
				'status' => false,
				'response' => $access['body']
			];
		}		
	}	

	public function Extract($response)
	{


		$jsondata = $response['response'];
		$edges = $jsondata['data']['user']['feed_reels_tray']['edge_reels_tray_to_reel']['edges'];

		$extract = array();
		foreach ($edges as $key => $postdata) {

			$userid = $postdata['node']['id'];
			$username = $postdata['node']['user']['username'];

			$extract[] = [
				'id' => $userid,
				'username' => $username
			];

		}

		return $extract;
	}	
}