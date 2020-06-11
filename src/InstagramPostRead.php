<?php namespace Riedayme\InstagramKit;

Class InstagramPostRead
{

	public $cookie;	
	public $csrftoken;
	public $results;

	public function SetCookie($data) 
	{
		$this->cookie = $data;
	}

	public function SetCSRF($data) 
	{
		$this->csrftoken = $data;
	}

	public function GetPost()
	{

		$userid = InstagramCookie::GetUIDCookie($this->cookie);

		$url = 'https://i.instagram.com/api/v1/feed/user/' . $userid;

		$headers = array();
		$headers[] = "Cookie: ".$this->cookie;

		$useragent = InstagramUserAgent::Get('Windows');

		$access = InstagramHelper::curl($url, false , $headers, false, $useragent);

		$response = json_decode($access['body']);

		if ($response->status != 'ok') {
			return false;
		}

		$this->results = $response;

		return $this;
	}

	public function Read()
	{
		$extract = array();
		foreach ($this->results->items as $post){

			$caption = $post->caption->text;
			if (!$caption) {
				$caption = false;
			}

			if ($post->media_type == 8) { // Album
				$image_original = $post->carousel_media[0]->image_versions2->candidates[0]->url;
				$image_small = $post->carousel_media[0]->image_versions2->candidates[1]->url;
				$type = "Album";
			}elseif ($post->media_type == 2) { // Video Type
				$image_original = $post->image_versions2->candidates[0]->url;
				$image_small = $post->image_versions2->candidates[1]->url;
				$type = "Video";
			}elseif ($post->media_type == 1) {// Single Photo
				$image_original = $post->image_versions2->candidates[0]->url;
				$image_small = $post->image_versions2->candidates[1]->url;
				$type = "Single";
			}			

			$extract[] = [
			'pk' => $post->pk,
			'media_type' => $post->media_type,
			'code' => $post->code,
			'caption' => $caption,
			'photo' => [
			'original' => $image_original,
			'small' => $image_small,
			'type' => $type,
			]
			];
		}

		return $extract;
	}

}