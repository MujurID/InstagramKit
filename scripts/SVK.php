<?php  
/**
* InstagramStoryVoteKuy v1.0
* Last Update 20 Juni 2020
* Author : Faanteyki
*/
require "../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramAuthAPI;
use Riedayme\InstagramKit\InstagramChecker;
use Riedayme\InstagramKit\InstagramResourceUser;
use Riedayme\InstagramKit\InstagramUserFollowersAPI;
use Riedayme\InstagramKit\InstagramFeedStoryAPI;
use Riedayme\InstagramKit\InstagramSeenStoryAPI;

Class InputHelper
{
	public function GetInputUsername($data = false) {

		if ($data) return $data;

		$CheckPreviousData = InstagramStoryVoteKuy::CheckPreviousData();

		if ($CheckPreviousData) {
			echo "Anda Memiliki akun yang tersimpan pilih angkanya dan gunakan kembali : ".PHP_EOL;
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

	public function GetInputStoryQuestionsMessage($data = false) {

		if ($data) return $data;

		echo "Masukan Daftar Jawaban Pertanyaan pisah dengan tanda | : ".PHP_EOL;

		$input = trim(fgets(STDIN));

		return (!$input) ? die('Jawaban pertanyaan masih kosong'.PHP_EOL) : $input;
	}

	public function GetInputLimitPerday($data = false) {

		if ($data) return $data;

		echo "Masukan Limit Vote per harinya (angka) : ".PHP_EOL;

		$input = trim(fgets(STDIN));

		if (strval($input) !== strval(intval($input))) 
		{
			die("Salah memasukan format, pastikan hanya angka".PHP_EOL);
		}

		return (!$input) ? die('Limit masih kosong'.PHP_EOL) : $input;
	}

	public function GetInputRangeStory($data = false) {

		if ($data) return $data;

		echo "Batas Story yang dibaca (angka): ".PHP_EOL;

		$input = trim(fgets(STDIN));

		if (strval($input) !== strval(intval($input))) 
		{
			die("Salah memasukan format, pastikan hanya angka".PHP_EOL);
		}

		return (!$input) ? die('Range Story masih kosong'.PHP_EOL) : $input;
	}

	public function GetInputTargets($data = false) {

		if ($data) return $data;

		echo "Masukan Akun target [pisah dengan tanda (,)] : ".PHP_EOL;
		echo "Ex : johny,awakening,travelergest".PHP_EOL;		

		$input = trim(fgets(STDIN));

		return (!$input) ? die('Target akun masih kosong'.PHP_EOL) : $input;
	}				
}

Class InstagramStoryVoteKuy
{

	public $username;
	public $cookie;
	public $csrftoken;

	public $question_message;
	public $limit_per_day;
	public $range_story;
	public $targets;

	public $current_loop = 0;

	public $next_id;

	public function Auth($data) 
	{

		if (is_array($data['username'])) {

			echo "[INFO] Login Menggunakan Akun yang sudah ada".PHP_EOL;

			$results = self::ReadPreviousData($data['username'][0]);

			echo "[INFO] Check Live Cookie".PHP_EOL;

			$check_cookie = InstagramChecker::CheckLiveCookie($results['cookie']);
			if (!$check_cookie) die("[ERROR] cookie tidak bisa digunakan".PHP_EOL);

		}else{	

			echo "[INFO] Login Menggunakan Username dan Password".PHP_EOL;

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

			echo "Menyimpan Data Login".PHP_EOL;

			$results['password'] = $data['password'];
			$results['question_message'] = $data['question_message'];
			$results['limit_per_day'] = $data['limit_per_day'];
			$results['range_story'] = $data['range_story'];
			$results['targets'] = $data['targets'];
			self::SaveLogin($results);
		}

		$this->cookie = $results['cookie'];
		$this->csrftoken = $results['csrftoken'];
		$this->username = $results['username'];

		$this->question_message = $results['question_message'];
		$this->limit_per_day = $results['limit_per_day'];
		$this->range_story = $results['range_story'];
		$this->targets = $results['targets'];
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

	public function GetShuffleTarget($index){

		$targetlist = explode(',', $this->targets);

		/* reset index to 0 */
		if ($index >= count($targetlist)) {
			$index = 0;
			$this->current_loop = 1;
		}else{
			$this->current_loop = $this->current_loop + 1;
		}

		return $targetlist[$index];
	}

	public function GetFollowersTarget()
	{

		$username = self::GetShuffleTarget($this->current_loop);

		$useridtarget = InstagramResourceUser::GetUserIdByScraping($username);

		$type = false;
		if ($this->next_id[$useridtarget]) {
			$type = 'Lanjut ';
		}

		echo "[INFO] {$type}Mendapatkan List Followers {$username}".PHP_EOL;

		$readfollowers = new InstagramUserFollowersAPI();
		$readfollowers->SetCookie($this->cookie);
		$userlist = $readfollowers->Process($useridtarget,$this->next_id[$useridtarget]);

		/* get userlist failed */
		if (!$userlist) return false;

		foreach ($userlist['users'] as $key => $user) {

			if($user['is_private']) continue;
			if(!$user['latest_reel_media']) continue;

			$results[] = [
			'userid' => $user['pk'],
			'username' => $user['username']
			];

		}

		if ($userlist['next_max_id']) {
			$this->next_id[$useridtarget] = $userlist['next_max_id'];
		}else{
			$this->next_id[$useridtarget] = false;
		}

		echo "[INFO] Berhasil mendapatkan ".count($results)." User".PHP_EOL;

		return $results;
	}

	public function GetStory()
	{

		$FollowersList = self::GetFollowersTarget();

		$readstory = new InstagramFeedStoryAPI();
		$readstory->SetCookie($this->cookie);

		$StoryList = array();
		foreach ($FollowersList as $user) {

			// echo "[INFO] Membaca Feed Story User {$user['username']} <-------------".PHP_EOL;

			$StoryUser = $readstory->GetStoryUser($user['userid']);

			foreach ($StoryUser as $story) {
				$StoryList[] = $story;
			}
		}

		echo "[INFO] Berhasil mendapatkan ".count($StoryList)." Story".PHP_EOL;

		return $StoryList;	
	}		

	public function SeenStory($story)
	{

		/* sync story data with log file */
		$sync = self::SyncStory($story['id']);
		if ($sync) 
		{
			echo "[SKIP] {$story['id']}, Story sudah dilihat.".PHP_EOL;
			return false;
		}

		echo "[INFO] Proses Seen Story {$story['username']}||{$story['id']}".PHP_EOL;

		$seenstory = new InstagramSeenStoryAPI();
		$seenstory->SetCookie($this->cookie);
		$seenstory->SetOption([
			'story_questions' => [
			'active' => true,
			'message' => self::GetMessage()
			],
			'story_polls' => [
			'active' => true,
			'vote' => rand(0,1)
			],
			'story_countdowns' => [
			'active' => true
			],
			'story_sliders' => [
			'active' => true,
			'vote' => '1'
			],
			'story_quizs' => [
			'active' => true
			],
			]);		

		$results = $seenstory->SeenStoryByAPI($story);

		if ($results != false) {
			echo "[SUCCESS] Success Seen Story {$story['id']} | Type : {$results['story_type']}".PHP_EOL;
			echo "[INFO] Response : {$results['story_response']}".PHP_EOL;
			self::SaveLog(strtolower($this->username),$story['id']);

			return true;
		}else{
			echo "[FAILED] Failed Seen Story {$story['id']}".PHP_EOL;
			return true;
		}
	}

	public function GetMessage()
	{

		$message = explode(',', $this->question_message);

		return $message[array_rand($message)];
	}

	public function SyncStory($storyid)
	{

		$ReadLog = self::ReadLog(strtolower($this->username));

		if (is_array($ReadLog) AND in_array($storyid, $ReadLog)) 
		{
			return true;
		}

		return false;
	}

	public function ReadLog($identity)
	{		

		$logfilename = "log/story-data-svk-{$identity}-".date('m-Y');
		$log_url = array();
		if (file_exists($logfilename)) 
		{
			$log_url = file_get_contents($logfilename);
			$log_url  = explode(PHP_EOL, $log_url);
		}

		return $log_url;
	}

	public function SaveLog($identity,$datastory)
	{
		return file_put_contents("log/story-data-svk-{$identity}-".date('m-Y'), $datastory.PHP_EOL, FILE_APPEND);
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

			$account['question_message'] = InputHelper::GetInputStoryQuestionsMessage();
			$account['limit_per_day'] = InputHelper::GetInputLimitPerday();
			$account['range_story'] = InputHelper::GetInputRangeStory();
			$account['targets'] = InputHelper::GetInputTargets();
		}

		$delay_default = 10;
		$delay = 10;
		$delaystory_default = 10;
		$delaystory = 10;

		/* Call Class */
		$Working = new InstagramStoryVoteKuy();
		$Working->Auth($account);

		$nostorystatus = 0;
		$seenstory = 0;
		while (true) {

			/* when nostorystatus 5 reset sleep value to default */
			if ($nostorystatus >= 5) {
				$delaystory = $delaystory_default;
				$nostorystatus = 0;
			}
			
			$StoryList = $Working->GetStory();

			if (empty($StoryList)) {

				// echo "[INFO] Tidak ditemukan Story, Coba lagi setelah {$delaystory} detik".PHP_EOL;
				// sleep($delaystory);

				// $delaystory = $delaystory*rand(2,3);
				// $nostorystatus++;

				continue;
			}

			foreach ($StoryList as $key => $story) {

				/* when seenstory 5 reset sleep value to default */
				if ($seenstory >= 5) {
					$delay = $delay_default;
					$seenstory = 0;
				}	

				$process_seen = $Working->SeenStory($story);

				if ($process_seen) 
				{
					echo "[INFO] Delay {$delay}".PHP_EOL;
					sleep($delay);
					$delay = $delay+5;
					$seenstory++;
				}

			}

		}		

	}
}

Worker::Run();
// use at you own risk