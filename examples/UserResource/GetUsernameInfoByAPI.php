<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramResourceUser;

$cookie = 'yourcookie';

$username = 'faanteyki';

$read = new InstagramResourceUser();

$results = $read->GetUsernameInfoByAPI($cookie,$username);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(2) {
  ["user"]=>
  array(49) {
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
    ["media_count"]=>
    int(1)
    ["geo_media_count"]=>
    int(0)
    ["follower_count"]=>
    int(65)
    ["following_count"]=>
    int(117)
    ["following_tag_count"]=>
    int(6)
    ["biography"]=>
    string(30) "Evertime, everything ,every..."
    ["biography_with_entities"]=>
    array(2) {
      ["raw_text"]=>
      string(30) "Evertime, everything ,every..."
      ["entities"]=>
      array(0) {
      }
    }
    ["external_url"]=>
    string(0) ""
    ["total_igtv_videos"]=>
    int(0)
    ["usertags_count"]=>
    int(0)
    ["is_favorite"]=>
    bool(false)
    ["is_favorite_for_stories"]=>
    bool(false)
    ["live_subscription_status"]=>
    string(7) "default"
    ["has_chaining"]=>
    bool(true)
    ["hd_profile_pic_versions"]=>
    array(2) {
      [0]=>
      array(3) {
        ["width"]=>
        int(320)
        ["height"]=>
        int(320)
        ["url"]=>
        string(243) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-19/s320x320/101502769_618477598877338_2170620851571916800_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=110&_nc_ohc=cgC2TcFUTAMAX-S3BJO&oh=54bb0671acc086cfbfd918b07fb3361d&oe=5F1334F4"
      }
      [1]=>
      array(3) {
        ["width"]=>
        int(640)
        ["height"]=>
        int(640)
        ["url"]=>
        string(243) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-19/s640x640/101502769_618477598877338_2170620851571916800_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=110&_nc_ohc=cgC2TcFUTAMAX-S3BJO&oh=2fe80d1e1e26549e6e960d3338745a3d&oe=5F154BC9"
      }
    }
    ["hd_profile_pic_url_info"]=>
    array(3) {
      ["url"]=>
      string(234) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-19/101502769_618477598877338_2170620851571916800_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=110&_nc_ohc=cgC2TcFUTAMAX-S3BJO&oh=39c2e0b9029c48f983c6b1e4c798e319&oe=5F14F474"
      ["width"]=>
      int(1080)
      ["height"]=>
      int(1080)
    }
    ["mutual_followers_count"]=>
    int(0)
    ["is_eligible_for_smb_support_flow"]=>
    bool(false)
    ["smb_support_partner"]=>
    NULL
    ["direct_messaging"]=>
    string(0) ""
    ["address_street"]=>
    string(0) ""
    ["business_contact_method"]=>
    string(0) ""
    ["category"]=>
    string(6) "Author"
    ["city_id"]=>
    int(0)
    ["city_name"]=>
    string(0) ""
    ["contact_phone_number"]=>
    string(0) ""
    ["is_call_to_action_enabled"]=>
    bool(false)
    ["latitude"]=>
    float(0)
    ["longitude"]=>
    float(0)
    ["public_email"]=>
    string(0) ""
    ["public_phone_country_code"]=>
    string(0) ""
    ["public_phone_number"]=>
    string(0) ""
    ["zip"]=>
    string(0) ""
    ["instagram_location_id"]=>
    string(0) ""
    ["is_business"]=>
    bool(false)
    ["account_type"]=>
    int(3)
    ["professional_conversion_suggested_account_type"]=>
    int(2)
    ["can_hide_category"]=>
    bool(true)
    ["can_hide_public_contacts"]=>
    bool(true)
    ["should_show_category"]=>
    bool(true)
    ["should_show_public_contacts"]=>
    bool(false)
  }
  ["status"]=>
  string(2) "ok"
}
*/