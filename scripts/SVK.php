<?php  
/**
* InstagramStoryVoteKuy
* Last Update 21 Juni 2020
* Author : Faanteyki
*/
require "../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramAuthAPI;
use Riedayme\InstagramKit\InstagramChecker;
use Riedayme\InstagramKit\InstagramResourceUser;
use Riedayme\InstagramKit\InstagramUserFollowers;
use Riedayme\InstagramKit\InstagramUserFollowersAPI;
use Riedayme\InstagramKit\InstagramFeedStoryAPI;
use Riedayme\InstagramKit\InstagramSeenStoryAPI;

date_default_timezone_set('Asia/Jakarta');

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

	public function GetInputRelog($data = false) {

		if ($data) return $data;

		echo "Apakah anda ingin relogin akun ini : (y/n)".PHP_EOL;

		$input = trim(fgets(STDIN));

		if (!in_array(strtolower($input),['y','n'])) 
		{
			die("Pilihan tidak diketahui".PHP_EOL);
		}

		return (!$input) ? die('Pilihan masih Kosong'.PHP_EOL) : $input;
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

	public function GetInputOnlyVote($data = false) 
	{

		if ($data) return $data;

		echo "Hanya Vote saja ? (y/n): ".PHP_EOL;

		$input = trim(fgets(STDIN));

		if (!in_array(strtolower($input),['y','n'])) 
		{
			die("Pilihan tidak diketahui".PHP_EOL);
		}

		return (!$input) ? die('Pilihan masih Kosong'.PHP_EOL) : $input;
	}

	public function GetInputTargets($data = false) {

		if ($data) return $data;

		echo "Masukan Akun target pisah dengan tanda , : ".PHP_EOL;	

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
	public $current_loop_message = 0;	

	public $next_id = array();

	public function Auth($data) 
	{

		if (is_array($data['username'])) {

			echo "[INFO] Login Menggunakan Akun yang sudah ada".PHP_EOL;

			$results = self::ReadPreviousData($data['username'][0]);

			$choice_relog = InputHelper::GetInputRelog();

			if ($choice_relog == 'y') {

				$relog_data['username'] = $results['username'];
				$relog_data['password'] = $results['password'];
				$relog_data['question_message'] = $results['question_message'];
				$relog_data['limit_per_day'] = $results['limit_per_day'];
				$relog_data['only_vote'] = $results['only_vote'];			
				$relog_data['targets'] = $results['targets'];

				return self::Auth($relog_data);
			}

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

				if (!is_array($results)) die($results);
			}

			echo "Menyimpan Data Login".PHP_EOL;

			$results['password'] = $data['password'];
			$results['question_message'] = $data['question_message'];
			$results['limit_per_day'] = $data['limit_per_day'];
			$results['only_vote'] = $data['only_vote'];			
			$results['targets'] = $data['targets'];
			self::SaveLogin($results);
		}

		$this->cookie = $results['cookie'];
		$this->csrftoken = $results['csrftoken'];
		$this->username = $results['username'];

		$this->question_message = $results['question_message'];
		$this->limit_per_day = $results['limit_per_day'];
		$this->only_vote = $results['only_vote'];		
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

		return trim($targetlist[$index]);
	}

	public function GetFollowersTarget()
	{

		$username = self::GetShuffleTarget($this->current_loop);

		$useridtarget = InstagramResourceUser::GetUserIdByScraping($username);

		//var_dump($this->next_id);

		$type = false;
		$next_id = false;
		if (!empty($this->next_id[$useridtarget])) {
			$type = 'Lanjut-'.$this->next_id[$useridtarget."_count"].' ';
			$this->next_id[$useridtarget."_count"] = $this->next_id[$useridtarget."_count"]+1;
			$next_id = $this->next_id[$useridtarget];
		}else{
			$this->next_id[$useridtarget."_count"] = 1;
		}

		echo "[INFO] {$type}Mendapatkan List Followers {$username}".PHP_EOL;

		$results = self::GetFollowersTargetByWeb($useridtarget,$next_id);
		// $results = self::GetFollowersTargetByAPI($useridtarget,$next_id);

		echo "[INFO] Berhasil mendapatkan ".count($results)." User".PHP_EOL;

		return $results;
	}

	public function GetFollowersTargetByWeb($useridtarget,$next_id)
	{
		$readfollowers = new InstagramUserFollowers();
		$readfollowers->SetCookie($this->cookie);
		$userlist = $readfollowers->Process($useridtarget,$next_id);

		// echo json_encode($userlist);
		// exit;

		/* get userlist failed */
		if (!$userlist) return false;

		$results = array();
		$edges = $userlist['data']['user']['edge_followed_by']['edges'];
		foreach ($edges as $node) {
			$user = $node['node'];
			$reel = $user['reel'];

			if($user['is_private']) continue;
			if(!$reel['latest_reel_media']) continue;

			$results[] = $user['id'];
		}

		$next_page = $userlist['data']['user']['edge_followed_by']['page_info'];
		if ($next_page['has_next_page']) {
			$this->next_id[$useridtarget] = $next_page['end_cursor'];
		}else{
			$this->next_id[$useridtarget] = false;
		}

		return $results;
	}

	public function GetFollowersTargetByAPI($useridtarget,$next_id)
	{
		$readfollowers = new InstagramUserFollowersAPI();
		$readfollowers->SetCookie($this->cookie);
		$userlist = $readfollowers->Process($useridtarget,$next_id);

		/* get userlist failed */
		if (!$userlist) return false;

		$results = array();
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

		return $results;
	}

	public function GetStory()
	{

		$FollowersList = self::GetFollowersTarget();

		/* get FollowersList failed */
		if (!$FollowersList) return 'failed_get_followers_list';

		$readstory = new InstagramFeedStoryAPI();
		$readstory->SetCookie($this->cookie);

		$StoryList = array();

		echo "[INFO] Membaca Feed Story dari ".count($FollowersList)." User".PHP_EOL;

		$StoryUser = $readstory->GetStoryUser($FollowersList);

		if (!$StoryUser) return false;
		
		foreach ($StoryUser as $story) {

			/* remove not story vote */
			if ($this->only_vote == 'y') {
				if ($story['story_detail']['type'] !== 'default') {
					$StoryList[] = $story;
				}
			}else{
				$StoryList[] = $story;
			}
		}

		echo "[INFO] Berhasil mendapatkan ".count($StoryList)." Story".PHP_EOL;

		return $StoryList;	
	}		

	public function SeenStory($story)
	{

		$count_today = self::ReadLogDaily(strtolower($this->username));

		if ($count_today >= $this->limit_per_day) {
			$startdate = date('Y-m-d H:i:s'); 
			$enddate = date('Y-m-d')."23:59:59"; 
			$remain_today = strtotime($enddate)-strtotime($startdate); 

			echo "[INFO] Telah mencapai batas limit perharinya, delay selama {$remain_today} detik".PHP_EOL;

			sleep($remain_today);
		}

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
			'message' => self::GetShuffleMessage($this->current_loop_message)
			],
			'story_polls' => [
			'active' => true,
			'vote' => '1'
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

			echo "[SUCCESS] Success Seen Story {$story['id']} | Type : {$story['story_detail']['type']}".PHP_EOL;
			echo "[INFO] Response : {$results['story_response']}".PHP_EOL;
			self::SaveLog(strtolower($this->username),$story['id']);
			self::SaveLogDaily(strtolower($this->username),$story['id']);

			if ($story['story_detail']['type'] == 'questions') {
				return 'questions';
			}

			return true;
		}else{
			echo "[FAILED] Failed Seen Story {$story['id']}".PHP_EOL;
			return false;
		}
	}

	public function GetShuffleMessage($index)
	{

		$message = explode('|', $this->question_message);

		/* reset index to 0 */
		if ($index >= count($message)) {
			$index = 0;
			$this->current_loop_message = 1;
		}else{
			$this->current_loop_message = $this->current_loop_message + 1;
		}

		return trim($message[$index]);		
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
		$log_id = array();
		if (file_exists($logfilename)) 
		{
			$log_id = file_get_contents($logfilename);
			$log_id  = explode(PHP_EOL, $log_id);
		}

		return $log_id;
	}

	public function SaveLog($identity,$datastory)
	{
		return file_put_contents("log/story-data-svk-{$identity}-".date('m-Y'), $datastory.PHP_EOL, FILE_APPEND);
	}	

	public function ReadLogDaily($identity)
	{		

		$logfilename = "log/count-story-data-svk-{$identity}-".date('d-m-Y');
		$log_id = array();
		if (file_exists($logfilename)) 
		{
			$log_id = file_get_contents($logfilename);
			$log_id  = explode(PHP_EOL, $log_id);
		}

		return count($log_id) - 1;
	}

	public function SaveLogDaily($identity,$datastory)
	{
		return file_put_contents("log/count-story-data-svk-{$identity}-".date('d-m-Y'), $datastory.PHP_EOL, FILE_APPEND);
	}	
}

Class Worker
{
	public function Run()
	{

		echo "Instagram Story Vote Kuy".PHP_EOL;

		$account['username'] = InputHelper::GetInputUsername();

		if (!is_array($account['username'])) {
			$account['password'] = InputHelper::GetInputPassword();

			$account['question_message'] = InputHelper::GetInputStoryQuestionsMessage();
			$account['limit_per_day'] = InputHelper::GetInputLimitPerday();
			$account['only_vote'] = InputHelper::GetInputOnlyVote();			
			$account['targets'] = InputHelper::GetInputTargets();
		}

		$delay_default = 10;
		$delay = 10;
		$delaystory_default = 10;
		$delaystory = 10;
		$delay_question = 60; /* 1 minutes delay question */

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

				echo "[SKIP] Tidak ditemukan Story untuk diproses".PHP_EOL;
				// echo "[INFO] Tidak ditemukan Story, Coba lagi setelah {$delaystory} detik".PHP_EOL;
				// sleep($delaystory);

				// $delaystory = $delaystory+5;
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

					if ($process_seen == 'questions') {
						echo "[INFO] Delay {$delay_question}".PHP_EOL;
						sleep($delay_question);
					}else{
						echo "[INFO] Delay {$delay}".PHP_EOL;
						sleep($delay);
						$delay = $delay+5;
					}

					$seenstory++;
				}

			}

		}		

	}
}

Worker::Run();
// use at you own risk