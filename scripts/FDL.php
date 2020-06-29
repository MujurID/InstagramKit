<?php  
/**
* InstagramFollowDMLike [Instagram Follow > DM > Like Post]
* Last Update 28 Juni 2020
* Author : Faanteyki
*/
require "../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramHelper;
use Riedayme\InstagramKit\InstagramAuthAPI;
use Riedayme\InstagramKit\InstagramChecker;
use Riedayme\InstagramKit\InstagramResourceUser;
use Riedayme\InstagramKit\InstagramUserFollowers;

use Riedayme\InstagramKit\InstagramUserFollow;
use Riedayme\InstagramKit\InstagramUserPost;
use Riedayme\InstagramKit\InstagramDirectCreateAPI;
use Riedayme\InstagramKit\InstagramDirectBroadcastAPI;
use Riedayme\InstagramKit\InstagramPostLike;

date_default_timezone_set('Asia/Jakarta');

Class InputHelper
{
	public function GetInputUsername($data = false) {

		if ($data) return $data;

		$CheckPreviousData = InstagramFollowDMLike::CheckPreviousData();

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

	public function GetInputDirectMessage($data = false) {

		if ($data) return $data;

		echo "Masukan pesan untuk direct message | : ".PHP_EOL;

		$input = trim(fgets(STDIN));

		return (!$input) ? die('Jawaban pertanyaan masih kosong'.PHP_EOL) : $input;
	}

	public function GetInputLimitPerday($data = false) {

		if ($data) return $data;

		echo "Masukan Limit Proses per harinya (angka) : ".PHP_EOL;

		$input = trim(fgets(STDIN));

		if (strval($input) !== strval(intval($input))) 
		{
			die("Salah memasukan format, pastikan hanya angka".PHP_EOL);
		}

		return (!$input) ? die('Limit masih kosong'.PHP_EOL) : $input;
	}

	public function GetInputTargets($data = false) {

		if ($data) return $data;

		echo "Masukan Akun target pisah dengan tanda , : ".PHP_EOL;	

		$input = trim(fgets(STDIN));

		return (!$input) ? die('Target akun masih kosong'.PHP_EOL) : $input;
	}				
}

Class InstagramFollowDMLike
{

	public $username;
	public $cookie;
	public $csrftoken;

	public $direct_message;
	public $limit_per_day;
	public $targets;

	public $current_loop_target = 0;
	public $current_loop_message = 0;		

	public $next_id = array();

	public $count_process = 0;

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
				$relog_data['direct_message'] = $results['direct_message'];
				$relog_data['limit_per_day'] = $results['limit_per_day'];
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
				$reconfig_data['direct_message'] = InputHelper::GetInputDirectMessage();
				$reconfig_data['limit_per_day'] = InputHelper::GetInputLimitPerday();
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
			$results['direct_message'] = $data['direct_message'];
			$results['limit_per_day'] = $data['limit_per_day'];
			$results['targets'] = $data['targets'];
			self::SaveLogin($results);
		}

		$this->cookie = $results['cookie'];
		$this->csrftoken = $results['csrftoken'];
		$this->username = $results['username'];

		$this->direct_message = $results['direct_message'];
		$this->limit_per_day = $results['limit_per_day'];
		$this->targets = $results['targets'];
	}

	public function SaveLogin($data){

		$filename = 'data/sc-fdl.json';

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

		$filename = 'data/sc-fdl.json';
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

		$filename = 'data/sc-fdl.json';
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
		if (!$userlist['status']) {
			return [];
		}

		if ($userlist['cursor'] !== null) {
			$this->next_id[$useridtarget] = $userlist['cursor'];
		}else{
			$this->next_id[$useridtarget] = false;
		}

		$results = $readfollowers->Extract($userlist);

		return $results;
	}

	public function FollowUser($userdata)
	{
		$follow = new InstagramUserFollow();
		$follow->SetCookie($this->cookie);
		
		$results = $follow->Process($userdata['userid']);

		if ($results['status'] != false) {
			echo "[".date('d-m-Y H:i:s')."] Sukses Follow User {$userdata['username']}".PHP_EOL;
			echo "[INFO] Response : {$results['response']}".PHP_EOL;	

			self::SaveLog(strtolower($this->username),$userdata['userid']);

			/* delay bot */
			self::DelayBot();		

			return true;
		}else{
			echo "[".date('d-m-Y H:i:s')."] Gagal Follow User {$userdata['username']}".PHP_EOL;
			echo "[INFO] Response : {$results['response']}".PHP_EOL;			
			return false;
		}	
	}

	public function DirectUser($userdata)
	{

		$userids[] = $userdata['userid'];
		$message = self::GetShuffleMessage($this->current_loop_message);

		$directcreate = new InstagramDirectCreateAPI();
		$directcreate->SetCookie($this->cookie);
		$get_thread_id = $directcreate->Process($userids);
		$thread_ids = [$get_thread_id['response']['thread_id']];

		$directcreate = new InstagramDirectBroadcastAPI();
		$directcreate->SetCookie($this->cookie);
		$results = $directcreate->Process($message,$thread_ids);

		if ($results['status'] != false) {
			echo "[".date('d-m-Y H:i:s')."] Sukses Kirim Pesan ke {$userdata['username']} text {$message}".PHP_EOL;
			echo "[INFO] Response : {$results['response']}".PHP_EOL;			

			/* delay bot */
			self::DelayBot();

			return true;
		}else{
			echo "[".date('d-m-Y H:i:s')."] Gagal Kirim Pesan ke {$userdata['username']} text {$message}".PHP_EOL;
			echo "[INFO] Response : {$results['response']}".PHP_EOL;			
			return false;
		}	
	}

	public function LikePost($userdata)
	{

		$readpost = new InstagramUserPost();
		$readpost->SetCookie($this->cookie);

		$getpost = $readpost->Process($userdata['userid']);

		if (!$getpost['status']) {
			echo "[INFO] Gagal mendapatkan post dari : {$userdata['username']}".PHP_EOL;					
			echo "[INFO] Response : {$getpost['response']}".PHP_EOL;			
			return false;
		}

		$postdata = $readpost->Extract($getpost);

		$likepost = new InstagramPostLike();
		$likepost->SetCookie($this->cookie);

		$current = 0;
		$limit = 3;
		$delay = 14;
		foreach ($postdata as $post) {

			$results = $likepost->Process($post['id']);

			if ($results['status'] != false) {
				echo "[".date('d-m-Y H:i:s')."] Sukses Like post {$post['url']}".PHP_EOL;
				echo "[INFO] Response : {$results['response']}".PHP_EOL;	

				echo "[INFO] Delay {$delay}".PHP_EOL;
				sleep($delay);
				$delay = $delay+5;

				$current++;
				
			}else{
				echo "[".date('d-m-Y H:i:s')."] Gagal Like post {$post['url']}".PHP_EOL;
				echo "[INFO] Response : {$results['response']}".PHP_EOL;
			}

			if ($current == $limit) {
				break;
			}

		}

	}	

	public function GetShuffleMessage($index)
	{

		$message = explode('|', $this->direct_message);

		/* reset index to 0 */
		if ($index >= count($message)) {
			$index = 0;
			$this->current_loop_message = 1;
		}else{
			$this->current_loop_message = $this->current_loop_message + 1;
		}

		return trim($message[$index]);		
	}

	public function SyncUser($userid)
	{

		$ReadLog = self::ReadLog(strtolower($this->username));

		if (is_array($ReadLog) AND in_array($userid, $ReadLog)) 
		{
			return true;
		}

		return false;
	}

	public function ReadLog($identity)
	{		

		$logfilename = "log/user-data-fdl-{$identity}";
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
		return file_put_contents("log/user-data-fdl-{$identity}", $datastory.PHP_EOL, FILE_APPEND);
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

		echo "Instagram Cangkul FDL".PHP_EOL;

		$account['username'] = InputHelper::GetInputUsername();

		if (!is_array($account['username'])) {
			$account['password'] = InputHelper::GetInputPassword();

			$account['direct_message'] = InputHelper::GetInputDirectMessage();
			$account['limit_per_day'] = InputHelper::GetInputLimitPerday();
			$account['targets'] = InputHelper::GetInputTargets();
		}

		$delay_default = 30;
		$delay = 30;

		/* Call Class */
		$Working = new InstagramFollowDMLike();
		$Working->Auth($account);
		$Working->GetUserIdTarget();

		while (true) {

			$userlist = $Working->GetFollowersTarget();	

			foreach ($userlist as $userdata) {

				if($userdata['is_private']) continue;
				if(!$userdata['latest_reel_media']) continue;

				/* sync user data with log file */
				if ($Working->SyncUser($userdata['userid'])) continue;

				$user_id = $userdata['userid'];

				$process_follow = $Working->FollowUser($userdata);
				if (!$process_follow) continue;

				$process_dm = $Working->DirectUser($userdata);
				if (!$process_dm) continue;

				$process_like_post = $Working->LikePost($userdata);

				$Working->count_process = $Working->count_process + 1;
				echo "[INFO] Total Proses berjalan : {$Working->count_process}".PHP_EOL;

				if ($Working->count_process >= $Working->limit_per_day) {
					$startdate = date('Y-m-d H:i:s'); 
					$enddate = date('Y-m-d')."23:59:59"; 
					$remain_today = strtotime($enddate)-strtotime($startdate); 

					echo "[INFO] Telah mencapai batas limit perharinya, delay selama {$remain_today} detik".PHP_EOL;

					sleep($remain_today);
				}

			}

		}		

	}
}

Worker::Run();
// use at you own risk