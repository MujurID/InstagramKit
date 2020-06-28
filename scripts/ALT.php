<?php  
/**
* Instagram Auto Like TimeLine
* Last Update 28 Juni 2020
* Author : Faanteyki
*/

require "../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramAuth;
use Riedayme\InstagramKit\InstagramChecker;
use Riedayme\InstagramKit\InstagramFeedTimeLine;
use Riedayme\InstagramKit\InstagramPostLike;

use Riedayme\InstagramKit\InstagramPostCommentsRead;
use Riedayme\InstagramKit\InstagramPostCommentsReplyRead;
use Riedayme\InstagramKit\InstagramPostCommentLike;

date_default_timezone_set('Asia/Jakarta');

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

	public function GetInputLikeComments($data = false) 
	{

		if ($data) return $data;

		echo "Like Comment Juga ? (y/n): ".PHP_EOL;

		$input = trim(fgets(STDIN));

		if (!in_array(strtolower($input),['y','n'])) 
		{
			die("Pilihan tidak diketahui".PHP_EOL);
		}

		return (!$input) ? die('Pilihan masih Kosong'.PHP_EOL) : $input;
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

		$filename = 'data/sc-global.json';

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

		$filename = 'data/sc-global.json';
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

		$filename = 'data/sc-global.json';
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

		$FeedTimeLine = new InstagramFeedTimeLine();
		$FeedTimeLine->SetCookie($this->cookie);

		$cursor = false;
		$results = array();
		$count = 0;
		$limit = 1;
		do {

			$post = $FeedTimeLine->Process($cursor);

			if (!$post['status']) {
				return 'fail_get_feed';
				break;
			}

			$data = $FeedTimeLine->Extract($post);

			$results = array_merge($results,$data);

			if ($post['cursor'] !== null) {
				$cursor = $post['cursor'];
			}else{
				$cursor = false;
			}

			$count = $count+1;
		} while ($cursor !== false AND $count < $limit);

		return $results;
	}

	public function LikePost($post)
	{

		$likepost = new InstagramPostLike();
		$likepost->SetCookie($this->cookie);
		$process = $likepost->Process($post['id']);

		return $process;
	}

	public function GetComment($shortcode)
	{

		$readcomments = new InstagramPostCommentsRead();
		$readcomments->SetCookie($this->cookie);

		$cursor = false;
		$resultscomments = array();
		$count = 0;
		$limit = 1;
		do {

			$post = $readcomments->Process($shortcode,$cursor);

			if (!$post['status']) {
				return false;
				break;
			}

			$data = $readcomments->Extract($post);

			$resultscomments = array_merge($resultscomments,$data);

			if ($post['cursor'] !== null) {
				$cursor = $post['cursor'];
			}else{
				$cursor = false;
			}

			$count = $count+1;
		} while ($cursor !== false AND $count < $limit);


		$readcomments_reply = new InstagramPostCommentsReplyRead();
		$readcomments_reply->SetCookie($this->cookie);

		$extract = array();
		foreach ($resultscomments as $comment) {

			/* skip if comment hasben liked */
			if ($comment['haslike'] == true AND $comment['count_reply'] < 1) continue;

			$extract[] = $comment;

			/* read reply comment */
			if ($comment['count_reply'] > 0) {

				$cursor = false;
				$results_reply = array();
				$count = 0;
				$limit = 1;
				do {

					$post = $readcomments_reply->Process($comment['id'],$cursor);

					if (!$post['status']) {
						echo $post['response'];
						break;
					}

					$data = $readcomments_reply->Extract($post);

					$results_reply = array_merge($results_reply,$data);

					if ($post['cursor'] !== null) {
						$cursor = $post['cursor'];
					}else{
						$cursor = false;
					}

					$count = $count+1;
				} while ($cursor !== false AND $count < $limit);

				foreach ($results_reply as $replycomment) {

					/* skip if reply comment hasben liked */
					if ($replycomment['haslike'] == true) continue;

					$extract[] = $replycomment;
				}
			}

		}
		
		return $extract;
	}

	public function LikeComment($comment)
	{

		$likecomment = new InstagramPostCommentLike();
		$likecomment->SetCookie($this->cookie);

		$process = $likecomment->Process($comment['id']);

		return $process;
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

		$delay_default = 30;
		$delay = 30;
		$delayfeed_default = 60;
		$delayfeed = 60;

		/* Call Class */
		$Working = new InstagramAutoLikeTIme();
		$Working->Auth($account);

		$like_comment = InputHelper::GetInputLikeComments();

		$nofeed = 0;
		$likepost = 0;
		$nogettimeline = 0;
		while (true) {

			/* when nofeed 5 reset sleep value to default */
			if ($nofeed >= 5) {
				$delayfeed = $delayfeed_default;
				$nofeed = 0;
			}

			/* when nogetstory 3 die because the cookie death */
			if ($nogettimeline >= 3) die("[ERROR] cookie sudah mati");

			echo "[INFO] Membaca Feed Timeline".PHP_EOL;

			$FeedList = $Working->GetFeed();

			if ($FeedList == 'fail_get_feed') {
				$nogettimeline++;
			}else{
				$nogettimeline = 0; /* reset value */
			}

			$temp_post_process = 0;
			foreach ($FeedList as $key => $post) {

				/* when likepost 5 reset sleep value to default */
				if ($likepost >= 5) {
					$delay = $delay_default;
					$likepost = 0;
				}	

				if ($post['haslike']) {
					echo "[SKIP] Post {$post['id']} sudah dilike. ".PHP_EOL;
				}else{					
					echo "[INFO] Proses Like Post {$post['username']}||{$post['id']}".PHP_EOL;

					$process_post = $Working->LikePost($post);

					if ($process_post['status'] != false) {
						echo "[".date('d-m-Y H:i:s')."] Sukses Like Post {$post['url']}".PHP_EOL;

						echo "[INFO] Delay {$delay}".PHP_EOL;
						sleep($delay);
						$delay = $delay+5;
						$likepost++;
						$temp_post_process++;
					}else{
						echo "[".date('d-m-Y H:i:s')."] Gagal Like Post {$post['url']}".PHP_EOL;
						echo "[INFO] Response : {$process['response']}".PHP_EOL;			
					}			
				}

				if ($like_comment == 'y') 
				{
					echo "[INFO] Membaca Komentar post : {$post['id']}".PHP_EOL;

					$comments = $Working->GetComment($post['code']);
					if (!$comments) 
					{
						echo "[INFO] Tidak ada komentar pada post : {$post['id']}".PHP_EOL;
						continue;
					}

					foreach ($comments as $comment) 
					{

						/* when likepost 5 reset sleep value to default */
						if ($likepost >= 5) {
							$delay = $delay_default;
							$likepost = 0;
						}

						echo "[INFO] Proses Like Comment {$comment['id']}".PHP_EOL;

						$process_comment = $Working->LikeComment($comment);

						if ($process_comment['status'] != false) {
							echo "[".date('d-m-Y H:i:s')."] Sukses Like Komentar {$comment['id']}".PHP_EOL;


							echo "[INFO] Delay {$delay}".PHP_EOL;
							sleep($delay);

							$delay = $delay+5;
							$likepost++;

						}else{
							echo "[".date('d-m-Y H:i:s')."] Gagal Like Komentar {$comment['id']}".PHP_EOL;
							echo "[INFO] Response : {$process_comment['response']}".PHP_EOL;			
						}


					}
				}

			}

			if ($temp_post_process < 1) 
			{
				echo "[INFO] Tidak ditemukan Post terbaru, Coba lagi setelah {$delayfeed} detik".PHP_EOL;
				sleep($delayfeed);

				$delayfeed = $delayfeed*rand(2,3);
				$nofeed++;

				continue;
			}

		}		

	}
}

Worker::Run();
// use at you own risk