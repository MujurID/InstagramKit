<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramFeedStory;

$datacookie = 'yourcookie';

$useragent = 'Instagram 9.6.0 Android (19/4.4.2; 480dpi; 1080x1920; samsung; SM-N900T; hltetmo; qcom; en_US)';

$userid = '13320596140';

$read = new InstagramFeedStory();
$read->SetCookie($datacookie);
$read->SetUserAgent($useragent);
$results = $read->GetFeedStoryUserByAPI($userid);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(3) {
  ["broadcast"]=>
  NULL
  ["reel"]=>
  array(14) {
    ["id"]=>
    int(13320596140)
    ["latest_reel_media"]=>
    int(1592488129)
    ["expiring_at"]=>
    int(1592574529)
    ["seen"]=>
    int(0)
    ["can_reply"]=>
    bool(true)
    ["can_gif_quick_reply"]=>
    bool(true)
    ["can_reshare"]=>
    bool(true)
    ["reel_type"]=>
    string(9) "user_reel"
    ["is_sensitive_vertical_ad"]=>
    bool(false)
    ["user"]=>
    array(8) {
      ["pk"]=>
      int(13320596140)
      ["username"]=>
      string(9) "faanteyki"
      ["full_name"]=>
      string(6) "Irfaan"
      ["is_private"]=>
      bool(false)
      ["profile_pic_url"]=>
      string(243) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-19/s150x150/101502769_618477598877338_2170620851571916800_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=110&_nc_ohc=cgC2TcFUTAMAX-S3BJO&oh=b59bfe4b0417b5800c08567153394361&oe=5F13658C"
      ["profile_pic_id"]=>
      string(31) "2320140972121789514_13320596140"
      ["friendship_status"]=>
      array(9) {
        ["following"]=>
        bool(false)
        ["followed_by"]=>
        bool(false)
        ["blocking"]=>
        bool(false)
        ["muting"]=>
        bool(false)
        ["is_private"]=>
        bool(false)
        ["incoming_request"]=>
        bool(false)
        ["outgoing_request"]=>
        bool(false)
        ["is_bestie"]=>
        bool(false)
        ["is_restricted"]=>
        bool(false)
      }
      ["is_verified"]=>
      bool(false)
    }
    ["items"]=>
    array(1) {
      [0]=>
      array(28) {
        ["taken_at"]=>
        int(1592488129)
        ["pk"]=>
        int(2334282149393729443)
        ["id"]=>
        string(31) "2334282149393729443_13320596140"
        ["device_timestamp"]=>
        int(30276456938188)
        ["media_type"]=>
        int(1)
        ["code"]=>
        string(11) "CBlCT9QJgej"
        ["client_cache_key"]=>
        string(30) "MjMzNDI4MjE0OTM5MzcyOTQ0Mw==.2"
        ["filter_type"]=>
        int(0)
        ["image_versions2"]=>
        array(1) {
          ["candidates"]=>
          array(2) {
            [0]=>
            array(5) {
              ["width"]=>
              int(720)
              ["height"]=>
              int(1280)
              ["url"]=>
              string(285) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/81118817_563196634392786_3445663286294953500_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=106&_nc_ohc=MaHQGysKvUUAX_STm1P&oh=82422623998b153cd1c4810db1badba8&oe=5EEDAFF4&ig_cache_key=MjMzNDI4MjE0OTM5MzcyOTQ0Mw%3D%3D.2"
              ["scans_profile"]=>
              string(3) "e35"
              ["estimated_scans_sizes"]=>
              array(9) {
                [0]=>
                int(4041)
                [1]=>
                int(8082)
                [2]=>
                int(12123)
                [3]=>
                int(16164)
                [4]=>
                int(20205)
                [5]=>
                int(24388)
                [6]=>
                int(29524)
                [7]=>
                int(32880)
                [8]=>
                int(36370)
              }
            }
            [1]=>
            array(5) {
              ["width"]=>
              int(240)
              ["height"]=>
              int(426)
              ["url"]=>
              string(294) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/p240x240/81118817_563196634392786_3445663286294953500_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=106&_nc_ohc=MaHQGysKvUUAX_STm1P&oh=611d0c610a05c778e8aa7d755f997045&oe=5EEDBFE9&ig_cache_key=MjMzNDI4MjE0OTM5MzcyOTQ0Mw%3D%3D.2"
              ["scans_profile"]=>
              string(3) "e35"
              ["estimated_scans_sizes"]=>
              array(9) {
                [0]=>
                int(1343)
                [1]=>
                int(2686)
                [2]=>
                int(4029)
                [3]=>
                int(5372)
                [4]=>
                int(6716)
                [5]=>
                int(8384)
                [6]=>
                int(108285)
                [7]=>
                int(12089)
                [8]=>
                int(12089)
              }
            }
          }
        }
        ["original_width"]=>
        int(720)
        ["original_height"]=>
        int(1280)
        ["user"]=>
        array(10) {
          ["pk"]=>
          int(13320596140)
          ["username"]=>
          string(9) "faanteyki"
          ["full_name"]=>
          string(6) "Irfaan"
          ["is_private"]=>
          bool(false)
          ["profile_pic_url"]=>
          string(243) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-19/s150x150/101502769_618477598877338_2170620851571916800_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=110&_nc_ohc=cgC2TcFUTAMAX-S3BJO&oh=b59bfe4b0417b5800c08567153394361&oe=5F13658C"
          ["profile_pic_id"]=>
          string(31) "2320140972121789514_13320596140"
          ["is_verified"]=>
          bool(false)
          ["has_anonymous_profile_picture"]=>
          bool(false)
          ["is_unpublished"]=>
          bool(false)
          ["is_favorite"]=>
          bool(false)
        }
        ["caption_is_edited"]=>
        bool(false)
        ["caption_position"]=>
        float(0)
        ["is_reel_media"]=>
        bool(true)
        ["photo_of_you"]=>
        bool(false)
        ["can_see_insights_as_brand"]=>
        bool(false)
        ["caption"]=>
        NULL
        ["can_viewer_save"]=>
        bool(true)
        ["organic_tracking_token"]=>
        string(344) "eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjp0cnVlLCJ1dWlkIjoiMzM0YTEyOWUyOGFmNDFlMzk5N2UxNzcyNTU5ZDU5ZjAyMzM0MjgyMTQ5MzkzNzI5NDQzIiwic2VydmVyX3Rva2VuIjoiMTU5MjQ4ODI3MjExNnwyMzM0MjgyMTQ5MzkzNzI5NDQzfDMxMzEwNjA3NzI0fGVkZjkzMTQzNWQyY2NmODY3NmU2NjY5MTUxNWMyZjFhZjY0ZTk0NWMyZjg1MzU4MWQ0MjY2NjI3NmU4ZTEyNWEifSwic2lnbmF0dXJlIjoiIn0="
        ["expiring_at"]=>
        int(1592574529)
        ["imported_taken_at"]=>
        int(1584778310)
        ["can_reshare"]=>
        bool(true)
        ["can_reply"]=>
        bool(true)
        ["story_questions"]=>
        array(1) {
          [0]=>
          array(11) {
            ["x"]=>
            float(0.5)
            ["y"]=>
            float(0.5)
            ["z"]=>
            int(0)
            ["width"]=>
            float(0.71666664)
            ["height"]=>
            float(0.246875)
            ["rotation"]=>
            float(0)
            ["is_pinned"]=>
            int(0)
            ["is_hidden"]=>
            int(0)
            ["is_sticker"]=>
            int(1)
            ["is_fb_sticker"]=>
            int(0)
            ["question_sticker"]=>
            array(8) {
              ["question_type"]=>
              string(4) "text"
              ["question_id"]=>
              int(18148097848060800)
              ["question"]=>
              string(4) "Test"
              ["media_id"]=>
              int(2334282149393729443)
              ["text_color"]=>
              string(7) "#000000"
              ["background_color"]=>
              string(7) "#ffffff"
              ["viewer_can_interact"]=>
              bool(true)
              ["profile_pic_url"]=>
              string(243) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-19/s150x150/101502769_618477598877338_2170620851571916800_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=110&_nc_ohc=cgC2TcFUTAMAX-S3BJO&oh=b59bfe4b0417b5800c08567153394361&oe=5F13658C"
            }
          }
        }
        ["supports_reel_reactions"]=>
        bool(true)
        ["can_send_custom_emojis"]=>
        bool(true)
        ["show_one_tap_fb_share_tooltip"]=>
        bool(true)
      }
    }
    ["prefetch_count"]=>
    int(0)
    ["has_besties_media"]=>
    bool(false)
    ["media_count"]=>
    int(1)
  }
  ["status"]=>
  string(2) "ok"
}
*/