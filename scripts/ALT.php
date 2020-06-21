<?php  
/**
* Instagram Auto Like TimeLine
* Last Update 21 Juni 2020
* Author : Faanteyki
*/

require "../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramAuth;
use Riedayme\InstagramKit\InstagramChecker;
use Riedayme\InstagramKit\InstagramFeedTimeLine;
use Riedayme\InstagramKit\InstagramPostLike;

Class InputHelper
{
	public function GetInputUsername($data = false) {

		if ($data) return $data;

		$CheckPreviousData = InstagramAutoLikeTIme::CheckPreviousData();

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
}

Class InstagramAutoLikeTIme
{

	public $cookie;
	public $csrftoken;

	public function Auth($data) 
	{

		if (is_array($data['username'])) {

			echo "[INFO] Login Menggunakan Cookie".PHP_EOL;

			$results = self::ReadPreviousData($data['username'][0]);

			echo "[INFO] Check Live Cookie".PHP_EOL;

			$check_cookie = InstagramChecker::CheckLiveCookie($results['cookie']);
			if (!$check_cookie) die("[ERROR] cookie tidak bisa digunakan".PHP_EOL);

		}else{	

			echo "[INFO] Login Menggunakan Username dan Password".PHP_EOL;

			$results = InstagramAuth::AuthLoginByWebAjax($data['username'],$data['password']);			

			echo "[INFO] Menyimpan Data Login".PHP_EOL;

			self::SaveLogin($results);
		}

		$this->cookie = $results['cookie'];
		$this->csrftoken = $results['csrftoken'];
	}

	public function SaveLogin($data){

		$filename = 'log/log-data.json';

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

		$filename = 'log/log-data.json';
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

		$filename = 'log/log-data.json';
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

	public function GetFeed()
	{

		echo "[INFO] Membaca Feed Timeline".PHP_EOL;

		$FeedTimeLine = new InstagramFeedTimeLine();
		$FeedTimeLine->SetCookie($this->cookie);

		$results = $FeedTimeLine->GetFeedTimeLine([
			'type' => 'graphql',
			'deep' => 3
			]);

		if (!$results) return 'fail_get_feed';

		echo "[INFO] Berhasil Mendapatkan Feed".PHP_EOL;

		return self::SyncPost($results);
	}

	public function LikePost($post)
	{
		echo "[INFO] Proses Like Post {$post['username']}||{$post['id']}".PHP_EOL;

		$likepost = new InstagramPostLike();
		$likepost->SetCookie($this->cookie);
		$process = $likepost->Process($post['id']);

		if ($process['status'] != false) {
			echo "[SUCCESS] Sukses Like Post {$post['url']}".PHP_EOL;
		}else{
			echo "[FAILED] Like Post {$post['url']}".PHP_EOL;
			echo "[INFO] Response : {$process['response']}".PHP_EOL;			
		}
	}

	public function SyncPost($postdata)
	{

		echo "Sync Feed Post".PHP_EOL;

		$results = array();
		foreach ($postdata as $post) {
			if ($post['haslike']) {
				echo "[SKIP] Post {$post['id']} sudah dilike. ".PHP_EOL;
				continue;
			}

			$results[] = $post;
		}

		return $results;
	}
}

Class Worker
{
	public function Run()
	{

		echo "Instagram Auto Like TimeLine".PHP_EOL;

		$account['username'] = InputHelper::GetInputUsername();

		if (!is_array($account['username'])) {
			$account['password'] = InputHelper::GetInputPassword();
		}

		$delay_default = 10;
		$delay = 10;
		$delayfeed_default = 10;
		$delayfeed = 10;

		/* Call Class */
		$Working = new InstagramAutoLikeTIme();
		$Working->Auth($account);

		$nofeed = 0;
		$likepost = 0;
		$nogetfeed = 0;
		while (true) {

			/* when nofeed 5 reset sleep value to default */
			if ($nofeed >= 5) {
				$delayfeed = $delayfeed_default;
				$nofeed = 0;
			}

			/* when nogetfeed 3 die because the cookie death */
			if ($nogetfeed >= 3) die("cookie sudah mati");

			$FeedList = $Working->GetFeed();

			if (empty($FeedList)) {

				if ($FeedList == 'fail_get_feed') {
					$nogetfeed++;
				}
				echo "[INFO] Tidak ditemukan Post, Coba lagi setelah {$delayfeed} detik".PHP_EOL;
				sleep($delayfeed);

				$delayfeed = $delayfeed*rand(2,3);
				$nofeed++;

				continue;
			}

			foreach ($FeedList as $key => $story) {

				/* when likepost 5 reset sleep value to default */
				if ($likepost >= 5) {
					$delay = $delay_default;
					$likepost = 0;
				}	

				$Working->LikePost($story);

				echo "[INFO] Delay {$delay}".PHP_EOL;
				sleep($delay);

				$delay = $delay+5;
				$likepost++;
			}

		}		

	}
}

Worker::Run();
// use at you own risk