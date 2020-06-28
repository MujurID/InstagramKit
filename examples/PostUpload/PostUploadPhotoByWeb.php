<?php

require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramPostUploadPhoto;
use Riedayme\InstagramKit\InstagramHelper;

$datacookie = 'csrftoken=76M5zu0rdO6U3we9h04IvXfqv2uAY0rD;rur=PRN;ds_user_id=31310607724;urlgen=\"{\\\"180.242.152.195\\\": 7713}:1joKj6:B7YPEmv47GTzn4oGx72aUGvSi1E\";sessionid=31310607724%3AwFJWi2lqakqGwe%3A4;';
$filename = 'nx.png'; /* photo extensiun must .jpg */
$caption = 'Wow This is caption you...'; /* caption text */

// convert image to jpeg
$convertimage =  InstagramHelper::convertToJpeg($filename,explode('.', $filename)[0].'.jpg');

$postupload = new InstagramPostUploadPhoto();
$postupload->SetCookie($datacookie);

$upload = $postupload->Process($convertimage);

if (!$upload['status']) {
	die($upload['response']);
}

$upload_id = $upload['response']['upload_id'];

$configure = $postupload->Configure($upload_id,$caption);

echo "<pre>";
var_dump($configure);
echo "</pre>";