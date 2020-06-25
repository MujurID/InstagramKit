<?php  
/**
* InstagramStoryVoteKuy
* Last Update 23 Juni 2020
* Author : Faanteyki
* Semaksimal mungkin mengurangi request terlalu banyak 
* ke api instagram untuk mengurangi limit.
*/
require "../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramHelper;
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

	public function GetInputReConfig($data = false) {

		if ($data) return $data;

		echo "Apakah anda mengatur ulang konfigurasi ? : (y/n)".PHP_EOL;

		$input = trim(fgets(STDIN));

		if (!in_array(strtolower($input),['y','n'])) 
		{
			die("Pilihan tidak diketahui".PHP_EOL);
		}

		return (!$input) ? die('Pilihan masih Kosong'.PHP_EOL) : $input;
	}

	public function GetInputChoiceVerify($data = false) {

		if ($data) return $data;

		echo "Pilih cara vertifikasi :".PHP_EOL;
		echo "[1] Kirim kode ke nomor handphone".PHP_EOL;
		echo "[2] Kirim kode ke email".PHP_EOL;

		$input = trim(fgets(STDIN));

		if (!in_array(strtolower($input),['1','2'])) 
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

		echo "Masukan jawaban question story, pisah dengan tanda | : ".PHP_EOL;

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
	public $only_vote;
	public $targets;

	public $current_loop_target = 0;
	public $current_loop_message = 0;		

	public $next_id = array();

	public $status_story_questions = true;
	public $status_story_polls = true;
	public $status_story_countdowns = true;
	public $status_story_sliders = true;
	public $status_story_quizs = true;

	public $count_process_seen = 0;
	public $count_process_vote = 0;	

	public $limit_process_question = 80;
	public $time_quesiton = false;

	public $delay_bot = 60;
	public $delay_bot_default = 60;
	public $delay_bot_count = 0;

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

			$choice_reconfig = InputHelper::GetInputReConfig();

			if ($choice_reconfig == 'y') {
				$reconfig_data['userid'] = $results['userid'];
				$reconfig_data['username'] = $results['username'];
				$reconfig_data['photo'] = $results['photo'];
				$reconfig_data['cookie'] = $results['cookie'];
				$reconfig_data['csrftoken'] = $results['csrftoken'];
				$reconfig_data['uuid'] = $results['uuid'];
				$reconfig_data['rank_token'] = $results['rank_token'];
				$reconfig_data['password'] = $results['password'];
				$reconfig_data['question_message'] = InputHelper::GetInputStoryQuestionsMessage();
				$reconfig_data['limit_per_day'] = InputHelper::GetInputLimitPerday();
				$reconfig_data['only_vote'] = InputHelper::GetInputOnlyVote();			
				$reconfig_data['targets'] = InputHelper::GetInputTargets();

				self::SaveLogin($reconfig_data);

				$results = $reconfig_data;
			}

			echo "[INFO] Check Live Cookie".PHP_EOL;

			$check_cookie = InstagramChecker::CheckLiveCookie($results['cookie']);
			if (!$check_cookie) die("[ERROR] Cookie sudah mati, silahkan relog".PHP_EOL);

		}else{	

			echo "[INFO] Login Menggunakan Username dan Password".PHP_EOL;

			$results = InstagramAuthAPI::Login($data['username'],$data['password']);			

			if ($results['response'] == 'checkpoint') {

				echo "[INFO] Akun anda terkena checkpoint".PHP_EOL;

				$choiceverify = InputHelper::GetInputChoiceVerify();
				$choiceverify = ($choiceverify == 1 ? 0 : 1);
				$sendCode = InstagramAuthAPI::CheckPointSend($results,$choiceverify);

				if (!$sendCode['status']) die($sendCode['response']);

				echo "[INFO] {$sendCode['response']}".PHP_EOL;

				$required['url'] = $results['url'];
				$required['cookie'] = $results['cookie'];
				$required['csrftoken'] = $results['csrftoken'];
				$required['guid'] = $results['guid'];

				$is_connected       = false;
				$is_connected_count = 1;

				do {

					$required['security_code'] = InputHelper::GetInputSecurityCode();
					$results = InstagramAuthAPI::CheckPointSolve($required);

					if ( $is_connected_count == 3 ) {
						echo "[INFO] 3x Kode Salah, ERROR".PHP_EOL;
						die($results['response']);
					}

					if (!isset($results['status']))
					{
						$is_connected = true;
					}else{
						echo "[INFO] Kode Salah, coba lagi".PHP_EOL;
					}

					$is_connected_count += 1;
				} while ( ! $is_connected );

			}else{
				/* remove response for saving login */
				unset($results['response']);
			}

			echo "[INFO] Menyimpan Data Login".PHP_EOL;

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

		$filename = 'data/sc-svk.json';

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

		$filename = 'data/sc-svk.json';
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

		$filename = 'data/sc-svk.json';
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

	public function GetUserIdTarget()
	{

		$targetlist = explode(',', $this->targets);

		echo "[INFO] Membaca UserId Target".PHP_EOL;

		$this->targets = array();

		foreach ($targetlist as $username) {

			$username = trim($username);
			$getuserid = InstagramResourceUser::GetUserIdByWeb($username);						
			// $getuserid = InstagramResourceUser::GetUserIdByAPI($this->cookie,$username);
			// $getuserid = InstagramResourceUser::GetUserIdByScraping($username);			

			if ($getuserid) {
				echo "[INFO] User {$username} | id => [$getuserid]".PHP_EOL;

				$this->targets[] = [
					'userid' => $getuserid,
					'username' => $username
				];
			}else{
				echo "[INFO] Failed Read User {$username}".PHP_EOL;
			}

		}

	}

	public function GetShuffleTarget($index){

		$targetlist = $this->targets;

		/* reset index to 0 */
		if ($index >= count($targetlist)) {
			$index = 0;
			$this->current_loop_target = 1;
		}else{
			$this->current_loop_target = $this->current_loop_target + 1;
		}

		return $targetlist[$index];
	}

	public function GetFollowersTarget()
	{

		$getTarget = self::GetShuffleTarget($this->current_loop_target);

		$usernametarget = $getTarget['username'];
		$useridtarget = $getTarget['userid'];

		$type = false;
		$next_id = false;
		if (!empty($this->next_id[$useridtarget])) {
			$type = 'Lanjut-'.$this->next_id[$useridtarget."_count"].' ';
			$this->next_id[$useridtarget."_count"] = $this->next_id[$useridtarget."_count"]+1;
			$next_id = $this->next_id[$useridtarget];
		}else{
			$this->next_id[$useridtarget."_count"] = 1;
		}

		echo "[INFO] {$type}Mendapatkan List Followers {$usernametarget}".PHP_EOL;

		$results = self::GetFollowersTargetByWeb($useridtarget,$next_id);
		// $results = self::GetFollowersTargetByAPI($useridtarget,$next_id);

		echo "[INFO] Berhasil mendapatkan ".count($results)." User".PHP_EOL;

		/* delay bot */
		self::DelayBot();

		return $results;
	}

	public function GetFollowersTargetByWeb($useridtarget,$next_id)
	{
		$readfollowers = new InstagramUserFollowers();
		$readfollowers->SetCookie($this->cookie);
		$userlist = $readfollowers->Process($useridtarget,$next_id);

		/* get userlist failed */
		if (!$userlist) return [];

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

		echo "[INFO] Membaca Feed Story dari ".count($FollowersList)." User".PHP_EOL;

		$DataStory = $readstory->GetStoryUser($FollowersList);
		$StoryUser = $readstory->ExtractStoryUser($DataStory);

		if (isset($StoryUser['status']) AND !$StoryUser['status']) return 'failed_get_story_user';
		
		$StoryList = array();
		foreach ($StoryUser as $story) {

			if ($story['story_detail']['type'] == 'questions' AND $this->status_story_questions == false) continue;
			if ($story['story_detail']['type'] == 'polls' AND $this->status_story_polls == false) continue;
			if ($story['story_detail']['type'] == 'countdowns' AND $this->status_story_countdowns == false) continue;
			if ($story['story_detail']['type'] == 'sliders' AND $this->status_story_sliders == false) continue;
			if ($story['story_detail']['type'] == 'quizs' AND $this->status_story_quizs == false) continue;												
			/* sync story data with log file */
			if (self::SyncStory($story['id'])) continue;

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

		/* delay bot */
		self::DelayBot();

		return $StoryList;	
	}

	public function SeenStory($storydata)
	{

		if (!$storydata) return false;

		$count_today = self::ReadLogDaily(strtolower($this->username));

		if ($count_today >= $this->limit_per_day) {
			$startdate = date('Y-m-d H:i:s'); 
			$enddate = date('Y-m-d')."23:59:59"; 
			$remain_today = strtotime($enddate)-strtotime($startdate); 

			echo "[INFO] Telah mencapai batas limit perharinya, delay selama {$remain_today} detik".PHP_EOL;

			sleep($remain_today);
		}

		$seenstory = new InstagramSeenStoryAPI();
		$seenstory->SetCookie($this->cookie);

		/* mass seen storydata */
		$BuildSeenStory = $seenstory->BuildSeenStory($storydata);
		$results = $seenstory->Process($BuildSeenStory);

		if ($results['status'] != false) {			

			$this->count_process_seen = $this->count_process_seen + count($storydata);

			echo PHP_EOL."[".date('d-m-Y H:i:s')."] Success Seen All Story | Total Process Seen : {$this->count_process_seen} ".PHP_EOL;
			echo "[INFO] Response : {$results['response']}".PHP_EOL.PHP_EOL;

			/* create log storydata default */
			foreach ($storydata as $story) {
				if ($story['story_detail']['type'] == 'default') {
					self::SaveLog(strtolower($this->username),$story['id']);
					self::SaveLogDaily(strtolower($this->username),$story['id']);
				}
			}

			return true;
		}else{
			echo PHP_EOL."!<-----------------[FAILED PROCESS]------------------>!".PHP_EOL;
			echo "[".date('d-m-Y H:i:s')."] Failed Seen All Story".PHP_EOL;
			echo "[INFO] Response : {$results['response']}".PHP_EOL;
			echo "!<-----------------[FAILED PROCESS]------------------>!".PHP_EOL.PHP_EOL;
			return false;
		}		
	}

	public function VoteStory($story)
	{

		if ($story['story_detail']['type'] == 'default') return false;

		/* sync story data with log file */
		$sync = self::SyncStory($story['id']);
		if ($sync) 
		{
			echo "[SKIP] {$story['id']}, Story sudah diproses.".PHP_EOL;
			return false;
		}

		if ($story['story_detail']['type'] == 'questions') {
			if ($this->time_quesiton AND strtotime(date('Y-m-d H:i:s')) <= strtotime($this->time_quesiton)) {
				echo "[SKIP] Skip Story Question sampai : {$this->time_quesiton}".PHP_EOL;
				return false;
			}
		}		

		echo "[INFO] Proses Vote Story {$story['username']}||{$story['id']}".PHP_EOL;

		$seenstory = new InstagramSeenStoryAPI();
		$seenstory->SetCookie($this->cookie);

		if ($story['story_detail']['type'] == 'questions') 
		{
			$answer = self::GetShuffleMessage($this->current_loop_message);
			$process_vote = $seenstory->AnswerQuestions($story,$answer);
		}
		elseif ($story['story_detail']['type'] == 'polls') 
		{
			$process_vote = $seenstory->VotePolls($story,'1');
		}
		elseif ($story['story_detail']['type'] == 'countdowns') 
		{
			$process_vote = $seenstory->FollowCountdowns($story);
		}
		elseif ($story['story_detail']['type'] == 'sliders') 
		{
			$min = 10; 
			$max = 90;
			$point = ( mt_rand( $min, $max ) / 100 );
			$point = ($point > 1 ? 1 : $point);
			$process_vote = $seenstory->VoteSliders($story,$point);
		}
		elseif ($story['story_detail']['type'] == 'quizs') 
		{
			$process_vote = $seenstory->AnswerQuizs($story);
		}

		if ($process_vote['status'] != false) {			

			$this->count_process_vote = $this->count_process_vote + 1; 

			echo PHP_EOL."[".date('d-m-Y H:i:s')."] Success Vote Story {$story['id']} | Type : {$story['story_detail']['type']} | Total Process Vote : {$this->count_process_vote} ".PHP_EOL;
			echo "[INFO] Response : {$process_vote['response']}".PHP_EOL.PHP_EOL;

			self::SaveLog(strtolower($this->username),$story['id']);
			self::SaveLogDaily(strtolower($this->username),$story['id']);

			if ($story['story_detail']['type'] == 'questions') {
				$limit_process = InstagramHelper::GetSleepTimeByLimit($this->limit_process_question);
				$this->time_quesiton = date('Y-m-d H:i:s',strtotime("+{$limit_process} seconds"));
				return 'questions';
			}

			return 'other';
		}else{
			echo PHP_EOL."!<-----------------[FAILED PROCESS]------------------>!".PHP_EOL;
			echo "[".date('d-m-Y H:i:s')."] Failed Vote Story {$story['id']} | Type : {$story['story_detail']['type']}".PHP_EOL;
			echo "[INFO] Response : {$process_vote['response']}".PHP_EOL;
			echo "!<-----------------[FAILED PROCESS]------------------>!".PHP_EOL.PHP_EOL;			
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

	public function DelayBot()
	{

		/* reset sleep value to default */
		if ($this->delay_bot_count >= 5) {
			$this->delay_bot = $this->delay_bot_default;
			$this->delay_bot_count = 0;
		}	

		echo "[INFO] Delay {$this->delay_bot}".PHP_EOL;
		sleep($this->delay_bot);
		$this->delay_bot = $this->delay_bot+5;
		$this->delay_bot_count++;
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

		/* Call Class */
		$Working = new InstagramStoryVoteKuy();
		$Working->Auth($account);
		$Working->GetUserIdTarget();

		$nostorystatus = 0;
		$seenstory = 0;
		while (true) {

			/* when nostorystatus 5 reset sleep value to default */
			if ($nostorystatus >= 5) {
				$delaystory = $delaystory_default;
				$nostorystatus = 0;
			}
			
			$StoryList = $Working->GetStory();

			if ($StoryList == 'failed_get_followers_list' OR $StoryList == 'failed_get_story_user') {
				echo "[INFO] Tidak ditemukan Story, Coba lagi setelah {$delaystory} detik".PHP_EOL;
				sleep($delaystory);

				$delaystory = $delaystory+5;
				$nostorystatus++;

				continue;
			}

			/* send mass viewing */
			$process_mass_viewing = $Working->SeenStory($StoryList);

			if ($process_mass_viewing) 
			{
				echo "[INFO] Delay {$delay}".PHP_EOL;
				sleep($delay);
				$delay = $delay+5;

				$seenstory++;
			}	

			foreach ($StoryList as $key => $story) {

				/* when seenstory 5 reset sleep value to default */
				if ($seenstory >= 5) {
					$delay = $delay_default;
					$seenstory = 0;
				}	

				$process_vote = $Working->VoteStory($story);

				if ($process_vote) 
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