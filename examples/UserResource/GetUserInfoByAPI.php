<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramResourceUser;

$cookie = 'yourcookie';

$read = new InstagramResourceUser();

$results = $read->GetUserInfoByAPI($cookie);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(2) {
  ["user"]=>
  array(73) {
    ["pk"]=>
    int(31310607724)
    ["username"]=>
    string(8) "riedayme"
    ["full_name"]=>
    string(8) "Riedayme"
    ["is_private"]=>
    bool(false)
    ["profile_pic_url"]=>
    string(265) "https://scontent-ssn1-1.cdninstagram.com/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=scontent-ssn1-1.cdninstagram.com&_nc_ohc=ZMRBdU8i2AoAX-om633&oh=abced888b5847019c7216e50f24dd092&oe=5F13AC8F&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2"
    ["is_verified"]=>
    bool(false)
    ["has_anonymous_profile_picture"]=>
    bool(true)
    ["media_count"]=>
    int(1)
    ["follower_count"]=>
    int(5)
    ["following_count"]=>
    int(22)
    ["following_tag_count"]=>
    int(1)
    ["biography"]=>
    string(0) ""
    ["can_link_entities_in_bio"]=>
    bool(true)
    ["biography_with_entities"]=>
    array(2) {
      ["raw_text"]=>
      string(0) ""
      ["entities"]=>
      array(0) {
      }
    }
    ["external_url"]=>
    string(0) ""
    ["can_boost_post"]=>
    bool(false)
    ["can_see_organic_insights"]=>
    bool(false)
    ["show_insights_terms"]=>
    bool(false)
    ["can_convert_to_business"]=>
    bool(true)
    ["can_create_sponsor_tags"]=>
    bool(false)
    ["is_allowed_to_create_standalone_personal_fundraisers"]=>
    bool(false)
    ["can_create_new_standalone_personal_fundraiser"]=>
    bool(false)
    ["can_be_tagged_as_sponsor"]=>
    bool(false)
    ["can_see_support_inbox"]=>
    bool(false)
    ["can_see_support_inbox_v1"]=>
    bool(false)
    ["total_igtv_videos"]=>
    int(0)
    ["total_clips_count"]=>
    int(0)
    ["total_ar_effects"]=>
    int(0)
    ["reel_auto_archive"]=>
    string(2) "on"
    ["is_profile_action_needed"]=>
    bool(false)
    ["usertags_count"]=>
    int(0)
    ["usertag_review_enabled"]=>
    bool(false)
    ["is_needy"]=>
    bool(true)
    ["is_interest_account"]=>
    bool(false)
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
        string(265) "https://scontent-ssn1-1.cdninstagram.com/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=scontent-ssn1-1.cdninstagram.com&_nc_ohc=ZMRBdU8i2AoAX-om633&oh=abced888b5847019c7216e50f24dd092&oe=5F13AC8F&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2"
      }
      [1]=>
      array(3) {
        ["width"]=>
        int(640)
        ["height"]=>
        int(640)
        ["url"]=>
        string(265) "https://scontent-ssn1-1.cdninstagram.com/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=scontent-ssn1-1.cdninstagram.com&_nc_ohc=ZMRBdU8i2AoAX-om633&oh=abced888b5847019c7216e50f24dd092&oe=5F13AC8F&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2"
      }
    }
    ["hd_profile_pic_url_info"]=>
    array(3) {
      ["url"]=>
      string(265) "https://scontent-ssn1-1.cdninstagram.com/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=scontent-ssn1-1.cdninstagram.com&_nc_ohc=ZMRBdU8i2AoAX-om633&oh=abced888b5847019c7216e50f24dd092&oe=5F13AC8F&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2"
      ["width"]=>
      int(150)
      ["height"]=>
      int(150)
    }
    ["has_placed_orders"]=>
    bool(false)
    ["can_tag_products_from_merchants"]=>
    bool(false)
    ["fbpay_experience_enabled"]=>
    bool(false)
    ["show_conversion_edit_entry"]=>
    bool(true)
    ["aggregate_promote_engagement"]=>
    bool(true)
    ["allowed_commenter_type"]=>
    string(3) "any"
    ["is_video_creator"]=>
    bool(false)
    ["has_profile_video_feed"]=>
    bool(false)
    ["has_highlight_reels"]=>
    bool(false)
    ["is_eligible_to_show_fb_cross_sharing_nux"]=>
    bool(true)
    ["page_id_for_new_suma_biz_account"]=>
    NULL
    ["eligible_shopping_signup_entrypoints"]=>
    array(0) {
    }
    ["can_be_reported_as_fraud"]=>
    bool(false)
    ["is_business"]=>
    bool(false)
    ["account_type"]=>
    int(1)
    ["professional_conversion_suggested_account_type"]=>
    int(2)
    ["is_call_to_action_enabled"]=>
    NULL
    ["linked_fb_info"]=>
    array(1) {
      ["linked_fb_user"]=>
      array(3) {
        ["id"]=>
        int(100016865703374)
        ["name"]=>
        string(8) "Riedayme"
        ["is_valid"]=>
        bool(true)
      }
    }
    ["can_see_primary_country_in_settings"]=>
    bool(false)
    ["personal_account_ads_page_name"]=>
    NULL
    ["personal_account_ads_page_id"]=>
    NULL
    ["include_direct_blacklist_status"]=>
    bool(true)
    ["can_follow_hashtag"]=>
    bool(true)
    ["is_potential_business"]=>
    bool(false)
    ["show_post_insights_entry_point"]=>
    bool(false)
    ["feed_post_reshare_disabled"]=>
    bool(false)
    ["besties_count"]=>
    int(0)
    ["show_besties_badge"]=>
    bool(false)
    ["recently_bestied_by_count"]=>
    int(0)
    ["nametag"]=>
    array(4) {
      ["mode"]=>
      int(0)
      ["gradient"]=>
      int(2)
      ["emoji"]=>
      string(4) "😀"
      ["selfie_sticker"]=>
      int(0)
    }
    ["existing_user_age_collection_enabled"]=>
    bool(false)
    ["about_your_account_bloks_entrypoint_enabled"]=>
    bool(false)
    ["auto_expand_chaining"]=>
    bool(false)
    ["highlight_reshare_disabled"]=>
    bool(false)
    ["is_memorialized"]=>
    bool(false)
    ["open_external_url_with_in_app_browser"]=>
    bool(true)
  }
  ["status"]=>
  string(2) "ok"
}
*/