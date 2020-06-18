<?php namespace Riedayme\InstagramKit;

Class InstagramSeenStory
{

	public $cookie;	
	public $csrftoken;
	public $useragent;

	public function SetCookie($data) 
	{
		$this->cookie = $data;
		$this->csrftoken = InstagramCookie::GetCSRFCookie($data);
	}
	
	public function SetUserAgent($data) 
	{
		$this->useragent = $data;
	}

	public function SetUUID($data) 
	{
		$this->uuid = $data;
	}

	public function SetUID($data) 
	{
		$this->uid = $data;
	}

	public function SetToken($data) 
	{
		$this->token = $data;
	}

	public function SeenStoryByWeb($postdata)
	{

		$url = 'https://www.instagram.com/stories/reel/seen';

		$headers = array();
		$headers[] = "User-Agent: ". InstagramUserAgent::Get('Windows');
		$headers[] = "X-Csrftoken: ".$this->csrftoken;
		$headers[] = "Cookie: ". $this->cookie;

		$time = time();
		$sendpost = "reelMediaId={$postdata['id']}&reelMediaOwnerId={$postdata['userid']}&reelId={$postdata['userid']}&reelMediaTakenAt={$postdata['taken_at']}&viewSeenAt={$time}";

		$access = InstagramHelper::curl($url, $sendpost , $headers);

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok') {
			return [
				'status' => true,
				'id' => $postdata['id'],
				'username' => $postdata['username']
			];
		}else{
			return false;
		}
	}	

	public function SeenStoryByAPI($storydata)
	{

		$is_vod = false;

		$params = '?' . ($is_vod==false ? 'reel=1' : 'reel=0') . '&' . ($is_vod==true ? 'live_vod=1' : 'live_vod=0');

		$url = 'https://i.instagram.com/api/v2/media/seen/'.$params;

		$reelId_o = $storydata['id'];
		$reelId = $storydata['id']."_".$storydata['userid'];
		$reels_real[$reelId] = $storydata['taken_at'].'_'.time();

		$data = json_encode([
			'_uuid'      => $this->uuid,
			'_uid'       => $this->uid,
			'_csrftoken' => $this->token,
			'live_vods_skipped' => [],
			'nuxes_skipped' => [],
			'nuxes' => [],
			'reels'      => ($is_vod == false ? $reels_real : []),
			'live_vods'  => ($is_vod == true ? $reels_real : []),
			'reel_media_skipped' => []
		]);

		// $data = '{
		// 	"container_module": {"feed_timeline"},
		// 	"live_vods_skipped": {},
		// 	"nuxes_skipped": {}, 
		// 	"nuxes": {}, 
		// 	"reels": {"'.$stories['reels'].'" : "'.$stories['reel'].'"}, 
		// 	"live_vods": {}, 
		// 	"reel_media_skipped": {}
		// }';
		
		// echo $data;
		// exit;

		$postdata = InstagramHelperAPI::generateSignature(json_encode($data));

		// $headers = [
		// 	'Connection: close',
		// 	'Accept: */*',
		// 	'Content-type: application/x-www-form-urlencoded; charset=UTF-8',
		// 	'Cookie2: $Version=2',
		// 	'Accept-Language: en-US',
		// ];

		$access = InstagramHelperAPI::curl($url, $postdata , false , $this->cookie , $this->useragent);

		// echo $access['header'];
		// echo $access['body'];
		// exit;

		$response = json_decode($access['body'],true);

		if ($response['status'] == 'ok') {
			return [
				'status' => true,
				'id' => $storydata['id'],
				'username' => $storydata['username']
			];
		}else{
			return false;
		}	
	}	
}