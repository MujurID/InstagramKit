<?php  
/**
* InstagramStoryVoteKuy v1.0
* Last Update 20 Juni 2020
* Author : Faanteyki
*/
require "../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramAuthAPI;
use Riedayme\InstagramKit\InstagramChecker;
use Riedayme\InstagramKit\InstagramUserFollowersAPI;
use Riedayme\InstagramKit\InstagramFeedStoryAPI;
use Riedayme\InstagramKit\InstagramSeenStoryAPI;

Class InputHelper
{
	public function GetInputUsername($data = false) {

		if ($data) return $data;

		$CheckPreviousData = InstagramStoryVoteKuy::CheckPreviousData();

		if ($CheckPreviousData) {
			echo "Anda Memiliki Cookie yang tersimpan pilih angkanya dan gunakan kembali : ".PHP_EOL;
			foreach ($CheckPreviousData as $key => $cookie) {
				echo "[{$key}] ".$cookie['username'].PHP_EOL;
			}
			echo "[x] Masuk menggunakan akun baru".PHP_EOL;

			echo "Pilihan Anda : ".PHP_EOL;

			$input = strtolower(trim(fgets(STDIN)));			

			if ($input != 'x') {

				if (strval($input) !== strval(intval($input))) {
					die("Salah memasukan format, pastikan hanya angka".PHP_EOL);
				}

				return [$input];
			}
		}	

		echo "Masukan Username: ".PHP_EOL;

		return trim(fgets(STDIN));
	}

	public function GetInputPassword($data = false) {

		if ($data) return $data;

		echo "Masukan Password: ".PHP_EOL;

		return trim(fgets(STDIN));
	}

	public function GetInputSecurityCode($data = false) {

		if ($data) return $data;

		echo "Masukan Kode Vertifikasi : ".PHP_EOL;

		return trim(fgets(STDIN));
	}
}

Class InstagramStoryVoteKuy
{

	public $username;
	public $cookie;
	public $csrftoken;

	public function Auth($data) 
	{

		if (is_array($data['username'])) {

			echo "[INFO] Login Menggunakan Cookie <-------------".PHP_EOL;

			$results = self::ReadPreviousData($data['username'][0]);

			echo "[INFO] Check Live Cookie".PHP_EOL;

			$check_cookie = InstagramChecker::CheckLiveCookie($results['cookie']);
			if (!$check_cookie) die("[ERROR] cookie tidak bisa digunakan".PHP_EOL);

		}else{	

			echo "[INFO] Login Menggunakan Username dan Password <-------------".PHP_EOL;

			$results = InstagramAuthAPI::Login($data['username'],$data['password']);			

			if ($results['response'] == 'checkpoint') {
				$required = InstagramAuthAPI::CheckPointSend($results);

				$required['url'] = $results['url'];
				$required['cookie'] = $results['cookie'];
				$required['csrftoken'] = $results['csrftoken'];
				$required['guid'] = $results['guid'];				
				$required['security_code'] = InputHelper::GetInputSecurityCode();

				$results = InstagramAuthAPI::CheckPointSolve($required);
			}

			echo "Menyimpan Data Login <-------------".PHP_EOL;

			self::SaveLogin($results);
		}

		$this->cookie = $results['cookie'];
		$this->csrftoken = $results['csrftoken'];
		$this->username = $results['username'];
	}

	public function SaveLogin($data){

		$filename = 'log/log-data-svk.json';

		if (file_exists($filename)) {
			$read = file_get_contents($filename);
			$read = json_decode($read,true);
			$dataexist = false;
			foreach ($read as $key => $logdata) {
				if ($logdata['userid'] == $data['userid']) {
					$inputdata[] = $data;
					$dataexist = true;
				}else{
					$inputdata[] = $logdata;
				}
			}

			if (!$dataexist) {
				$inputdata[] = $data;
			}
		}else{
			$inputdata[] = $data;
		}

		return file_put_contents($filename, json_encode($inputdata,JSON_PRETTY_PRINT));
	}

	public function CheckPreviousData()
	{

		$filename = 'log/log-data-svk.json';
		if (file_exists($filename)) {
			$read = file_get_contents($filename);
			$read = json_decode($read,TRUE);
			foreach ($read as $key => $logdata) {
				$inputdata[] = $logdata;
			}

			return $inputdata;
		}else{
			return false;
		}
	}

	public function ReadPreviousData($data)
	{

		$filename = 'log/log-data-svk.json';
		if (file_exists($filename)) {
			$read = file_get_contents($filename);
			$read = json_decode($read,TRUE);
			foreach ($read as $key => $logdata) {
				if ($key == $data) {
					$inputdata = $logdata;
					break;
				}
			}

			return $inputdata;
		}else{
			die("file tidak ditemukan");
		}
	}

	public function GetStory()
	{

		echo "Membaca Feed ALl Story <-------------".PHP_EOL;

		$FeedStory = new InstagramFeedStory();
		$FeedStory->SetCookie($this->cookie);
		$FeedStory->SetCSRF($this->csrftoken);
		$FeedStory->GetQueryHash();				
		$StoryList = $FeedStory->GetStoryList();
		
		if (!$StoryList) return 'fail_get_all_story';

		echo "Membaca Feed Story User <-------------".PHP_EOL;

		$StoryUser = $FeedStory->GetStoryUser($StoryList);

		if (!$StoryUser) return 'fail_get_story_user';

		echo "Berhasil Mendapatkan Feed Story <-------------".PHP_EOL;

		return self::SyncStory($StoryUser);
	}

	public function SeenStory($story)
	{
		echo "Proses Seen Story {$story['username']}||{$story['id']} <-------------".PHP_EOL;

		$seenstory = new InstagramSeenStory();
		$seenstory->SetCookie($this->cookie);
		$seenstory->SetCSRF($this->csrftoken);
		$process = $seenstory->SeenStoryByWeb($story);

		if ($process != false) {
			echo "Success Seen Story {$story['id']} <-------------".PHP_EOL;
			self::SaveLog($this->username,$story['id']);
		}else{
			echo "Failed".PHP_EOL;
		}
	}

	public function SyncStory($storydata)
	{

		echo "Sync Story User <-------------".PHP_EOL;

		$ReadLog = self::ReadLog($this->username);

		$results = array();
		$freshstory = array();
		foreach ($storydata as $story) {
			if (is_array($ReadLog) AND in_array($story['id'], $ReadLog)) {
				echo "Skip {$story['id']}, Story sudah dilihat. ".PHP_EOL;
				$freshstory[] = $story['id'];
				continue;
			}

			$results[] = $story;
		}

		/* Update Log Data Fresh Story */
		if (count($storydata) != count($ReadLog) - 1) {
			echo "Update Log Story <-------------".PHP_EOL;
			self::SaveLog($this->username,implode(PHP_EOL, $freshstory),false);
		}

		return $results;
	}

	public function ReadLog($identity)
	{		

		$logfilename = "log/story-data-{$identity}";
		$log_url = array();
		if (file_exists($logfilename)) 
		{
			$log_url = file_get_contents($logfilename);
			$log_url  = explode(PHP_EOL, $log_url);
		}

		return $log_url;
	}

	public function SaveLog($identity,$datastory,$append = true)
	{
		if ($append) {
			return file_put_contents("log/story-data-{$identity}", $datastory.PHP_EOL, FILE_APPEND);
		}else{			
			return file_put_contents("log/story-data-{$identity}", $datastory.PHP_EOL);
		}
	}
}

Class Worker
{
	public function Run()
	{

		echo " --- Instagram Story Vote Kuy ---".PHP_EOL;

		$account['username'] = InputHelper::GetInputUsername();

		if (!is_array($account['username'])) {
			$account['password'] = InputHelper::GetInputPassword();
		}

		$delay_default = 10;
		$delay = 10;
		$delaystory_default = 10;
		$delaystory = 10;

		/* Call Class */
		$Working = new InstagramStoryVoteKuy();
		$Working->Auth($account);

		exit;

		$nostorystatus = 0;
		$seenstory = 0;
		$nogetfeed = 0;
		while (true) {

			/* when nostorystatus 5 reset sleep value to default */
			if ($nostorystatus >= 5) {
				$delaystory = $delaystory_default;
				$nostorystatus = 0;
			}
			
			$StoryList = $Working->GetStory();

			if (empty($StoryList)) {

				if ($StoryList == 'fail_get_all_story' OR $StoryList == 'fail_get_story_user') {
					$nogetfeed++;
				}

				echo "Tidak ditemukan Story, Coba lagi setelah {$delaystory} detik".PHP_EOL;
				sleep($delaystory);

				$delaystory = $delaystory*rand(2,3);
				$nostorystatus++;

				continue;
			}

			foreach ($StoryList as $key => $story) {

				/* when seenstory 5 reset sleep value to default */
				if ($seenstory >= 5) {
					$delay = $delay_default;
					$seenstory = 0;
				}	

				$Working->SeenStory($story);

				echo "Delay {$delay} <--------------".PHP_EOL;
				sleep($delay);

				$delay = $delay+5;
				$seenstory++;
			}

		}		

	}
}

Worker::Run();
// use at you own risk