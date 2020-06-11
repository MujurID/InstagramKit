<?php

require "../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramPhotoUpload;

$datacookie = 'yourcookie';
$filename = 'photo.jpg'; /* photo extensiun must .jpg */
$caption = 'Wow This is caption you...'; /* caption text */

$Upload = new InstagramPhotoUpload();
$Upload->Auth($datacookie,'cookie');

$Upload->UploadPhoto($filename);
$Upload->CaptionPhoto($caption);

$results = $Upload->Results();

echo "<pre>";
var_dump($results);
echo "</pre>";