<?php namespace Riedayme\InstagramKit;

Class InstagramDirectBroadcastAPI
{

	public $cookie;	

	public function SetCookie($data) 
	{
		$this->cookie = $data;
	}

	public function Process($message,$thread_ids)
	{

		$url = "https://i.instagram.com/api/v1/direct_v2/threads/broadcast/text/";

		$data = json_encode([
			'text'   => $message,
			'thread_ids' => '['.implode(',', $thread_ids).']'
		]);

		$buildpostdata = InstagramHelperAPI::generateSignature($data);

		$access = InstagramHelperAPI::curl($url, $buildpostdata , false , $this->cookie , InstagramUserAgent::Get('Android'));

		$response = json_decode($access['body'],true);
		
		if ($response['status'] == 'ok') {
			return [
				'status' => true,
				'response' => 'success send message '. $message,
			];
		}else{
			return [
				'status' => false,
				'response' => $access['body']
			];
		}

	}

}

/*
{
  "threads": [
    {
      "thread_id": "340282366841710300949128295959165536416",
      "thread_v2_id": "18026120941275296",
      "users": [
        {
          "pk": 9868652404,
          "username": "relaxing.media",
          "full_name": "Relaxing Media",
          "is_private": false,
          "profile_pic_url": "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-19/s150x150/104307119_305434823951354_7692373176389732433_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com\u0026_nc_cat=102\u0026_nc_ohc=Qwf8OEbvZbQAX_xjTf0\u0026oh=02460ce1c9922205bb0297ad69391f10\u0026oe=5F22F427",
          "profile_pic_id": "2332332807793181419_9868652404",
          "friendship_status": {
            "following": true,
            "blocking": false,
            "is_private": false,
            "incoming_request": false,
            "outgoing_request": false,
            "is_bestie": false,
            "is_restricted": false
          },
          "is_verified": false,
          "has_anonymous_profile_picture": false,
          "has_threads_app": false,
          "is_using_unified_inbox_for_direct": false,
          "interop_messaging_user_fbid": 118577952861452
        },
        {
          "pk": 13320596140,
          "username": "faanteyki",
          "full_name": "Irfaan",
          "is_private": false,
          "profile_pic_url": "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-19/s150x150/101502769_618477598877338_2170620851571916800_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com\u0026_nc_cat=110\u0026_nc_ohc=t3eNI5RqGIUAX8qJHGz\u0026oh=626ece894d2bfe664dc7dad542ba50da\u0026oe=5F23378C",
          "profile_pic_id": "2320140972121789514_13320596140",
          "friendship_status": {
            "following": false,
            "blocking": false,
            "is_private": false,
            "incoming_request": false,
            "outgoing_request": false,
            "is_bestie": false,
            "is_restricted": false
          },
          "is_verified": false,
          "has_anonymous_profile_picture": false,
          "has_threads_app": false,
          "is_using_unified_inbox_for_direct": false,
          "interop_messaging_user_fbid": 122779545777312
        }
      ],
      "left_users": [
        
      ],
      "admin_user_ids": [
        31310607724
      ],
      "items": [
        {
          "item_id": "29391841216169073276775275534745600",
          "user_id": 31310607724,
          "timestamp": 1593334904995975,
          "item_type": "text",
          "text": "hello works",
          "show_forward_attribution": false
        }
      ],
      "last_activity_at": 1593334904995975,
      "muted": false,
      "is_pin": false,
      "named": false,
      "canonical": true,
      "pending": false,
      "archived": false,
      "thread_type": "private",
      "viewer_id": 31310607724,
      "thread_title": "faanteyki, relaxing.media",
      "folder": 0,
      "vc_muted": false,
      "is_group": true,
      "mentions_muted": false,
      "approval_required_for_new_members": false,
      "input_mode": 0,
      "business_thread_folder": null,
      "read_state": null,
      "last_non_sender_item_at": 0,
      "assigned_admin_id": null,
      "shh_mode_enabled": false,
      "inviter": {
        "pk": 31310607724,
        "username": "riedayme",
        "full_name": "Riedayme",
        "is_private": false,
        "profile_pic_url": "https://instagram.fdel16-1.fna.fbcdn.net/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=instagram.fdel16-1.fna.fbcdn.net\u0026_nc_ohc=VuHrdWdZLhYAX-hSF8D\u0026oh=ea3a5965858233f24b99ec1cb294cc13\u0026oe=5F237E8F\u0026ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2",
        "is_verified": false,
        "has_anonymous_profile_picture": true,
        "reel_auto_archive": "on",
        "allowed_commenter_type": "any"
      },
      "has_older": true,
      "has_newer": true,
      "last_seen_at": {
        "31310607724": {
          "timestamp": "1593334904995975",
          "item_id": "29391841216169073276775275534745600",
          "shh_seen_state": {
            
          }
        }
      },
      "newest_cursor": "29391841216169073276775275534745600",
      "oldest_cursor": "29391841216169073276775275534745600",
      "next_cursor": "29391841216169073276775275534745601",
      "prev_cursor": "29391841216169073276775275534745599",
      "last_permanent_item": {
        "item_id": "29391841216169073276775275534745600",
        "user_id": 31310607724,
        "timestamp": 1593334904995975,
        "item_type": "text",
        "text": "hello works",
        "show_forward_attribution": false
      }
    }
  ],
  "status": "ok"
}
 */