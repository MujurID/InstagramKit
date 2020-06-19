<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramResourceUser;

$cookie = 'yourcookie';

$read = new InstagramResourceUser();

$results = $read->GetCurrentUserInfoByAPI($cookie);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(2) {
  ["user"]=>
  array(22) {
    ["pk"]=>
    int(31310607724)
    ["username"]=>
    string(8) "riedayme"
    ["full_name"]=>
    string(8) "Riedayme"
    ["is_private"]=>
    bool(false)
    ["profile_pic_url"]=>
    string(263) "https://instagram.fkhi2-1.fna.fbcdn.net/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=instagram.fkhi2-1.fna.fbcdn.net&_nc_ohc=ZMRBdU8i2AoAX83wyVK&oh=4766b3e6764df01bac7cafd1f47768ad&oe=5F13AC8F&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2"
    ["is_verified"]=>
    bool(false)
    ["has_anonymous_profile_picture"]=>
    bool(true)
    ["biography"]=>
    string(0) ""
    ["external_url"]=>
    string(0) ""
    ["reel_auto_archive"]=>
    string(2) "on"
    ["hd_profile_pic_versions"]=>
    array(2) {
      [0]=>
      array(3) {
        ["width"]=>
        int(320)
        ["height"]=>
        int(320)
        ["url"]=>
        string(263) "https://instagram.fkhi2-1.fna.fbcdn.net/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=instagram.fkhi2-1.fna.fbcdn.net&_nc_ohc=ZMRBdU8i2AoAX83wyVK&oh=4766b3e6764df01bac7cafd1f47768ad&oe=5F13AC8F&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2"
      }
      [1]=>
      array(3) {
        ["width"]=>
        int(640)
        ["height"]=>
        int(640)
        ["url"]=>
        string(263) "https://instagram.fkhi2-1.fna.fbcdn.net/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=instagram.fkhi2-1.fna.fbcdn.net&_nc_ohc=ZMRBdU8i2AoAX83wyVK&oh=4766b3e6764df01bac7cafd1f47768ad&oe=5F13AC8F&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2"
      }
    }
    ["hd_profile_pic_url_info"]=>
    array(3) {
      ["url"]=>
      string(263) "https://instagram.fkhi2-1.fna.fbcdn.net/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=instagram.fkhi2-1.fna.fbcdn.net&_nc_ohc=ZMRBdU8i2AoAX83wyVK&oh=4766b3e6764df01bac7cafd1f47768ad&oe=5F13AC8F&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2"
      ["width"]=>
      int(150)
      ["height"]=>
      int(150)
    }
    ["show_conversion_edit_entry"]=>
    bool(false)
    ["allowed_commenter_type"]=>
    string(3) "any"
    ["is_business"]=>
    bool(false)
    ["account_type"]=>
    int(1)
    ["professional_conversion_suggested_account_type"]=>
    int(2)
    ["is_call_to_action_enabled"]=>
    NULL
    ["personal_account_ads_page_name"]=>
    NULL
    ["personal_account_ads_page_id"]=>
    NULL
    ["trusted_username"]=>
    string(8) "riedayme"
    ["trust_days"]=>
    int(14)
  }
  ["status"]=>
  string(2) "ok"
}
*/