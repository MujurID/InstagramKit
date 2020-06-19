<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramChecker;

$access_token = 'yourtoken';

$check = new InstagramChecker();
$results =$check->AccountConnectedWithFacebook($access_token);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(2) {
  ["userid"]=>
  string(11) "31310607724"
  ["header"]=>
  string(3474) "HTTP/1.1 200 OK
Content-Type: application/json; charset=utf-8
Vary: Cookie, Accept-Language
Content-Language: en
Date: Thu, 18 Jun 2020 21:27:01 GMT
Strict-Transport-Security: max-age=31536000
Cache-Control: private, no-cache, no-store, must-revalidate
Pragma: no-cache
Expires: Sat, 01 Jan 2000 00:00:00 GMT
X-Frame-Options: SAMEORIGIN
content-security-policy: report-uri https://www.instagram.com/security/csp_report/; default-src 'self' https://www.instagram.com; img-src https: data: blob:; font-src https: data:; media-src 'self' blob: https://www.instagram.com https://*.cdninstagram.com https://*.fbcdn.net; manifest-src 'self' https://www.instagram.com; script-src 'self' https://instagram.com https://www.instagram.com https://*.www.instagram.com https://*.cdninstagram.com wss://www.instagram.com https://*.facebook.com https://*.fbcdn.net https://*.facebook.net 'unsafe-inline' 'unsafe-eval' blob:; style-src 'self' https://*.www.instagram.com https://www.instagram.com 'unsafe-inline'; connect-src 'self' https://instagram.com https://www.instagram.com https://*.www.instagram.com https://graph.instagram.com https://*.graph.instagram.com https://*.cdninstagram.com https://api.instagram.com https://i.instagram.com wss://www.instagram.com wss://edge-chat.instagram.com https://*.facebook.com https://*.fbcdn.net https://*.facebook.net chrome-extension://boadgeojelhgndaghljhdicfkmllpafd blob:; worker-src 'self' blob: https://www.instagram.com; frame-src 'self' https://instagram.com https://www.instagram.com https://staticxx.facebook.com https://www.facebook.com https://web.facebook.com https://connect.facebook.net https://m.facebook.com; object-src 'none'; upgrade-insecure-requests
X-Content-Type-Options: nosniff
X-XSS-Protection: 0
x-aed: 15
Access-Control-Expose-Headers: X-IG-Set-WWW-Claim
Set-Cookie: target=""; Domain=instagram.com; expires=Thu, 01-Jan-1970 00:00:00 GMT; Max-Age=0; Path=/
Set-Cookie: target=""; Domain=.instagram.com; expires=Thu, 01-Jan-1970 00:00:00 GMT; Max-Age=0; Path=/
Set-Cookie: target=""; Domain=i.instagram.com; expires=Thu, 01-Jan-1970 00:00:00 GMT; Max-Age=0; Path=/
Set-Cookie: target=""; Domain=.i.instagram.com; expires=Thu, 01-Jan-1970 00:00:00 GMT; Max-Age=0; Path=/
Set-Cookie: target=""; Domain=www.instagram.com; expires=Thu, 01-Jan-1970 00:00:00 GMT; Max-Age=0; Path=/
Set-Cookie: target=""; Domain=.www.instagram.com; expires=Thu, 01-Jan-1970 00:00:00 GMT; Max-Age=0; Path=/
Set-Cookie: target=""; expires=Thu, 01-Jan-1970 00:00:00 GMT; Max-Age=0; Path=/
Set-Cookie: csrftoken=imkmidhB2l7pP3LNhKE0YZjUFtAATZSQ; Domain=.instagram.com; expires=Thu, 17-Jun-2021 21:27:01 GMT; Max-Age=31449600; Path=/; Secure
Set-Cookie: ig_did=D9EC8738-0992-4570-99C4-30E6BCEB0866; Domain=.instagram.com; expires=Sun, 16-Jun-2030 21:27:01 GMT; HttpOnly; Max-Age=315360000; Path=/; Secure
Set-Cookie: rur=VLL; Domain=.instagram.com; HttpOnly; Path=/; Secure
Set-Cookie: mid=XuvcJAAEAAFMfTeIsLn5qLEwTv48; Domain=.instagram.com; expires=Sun, 16-Jun-2030 21:27:01 GMT; Max-Age=315360000; Path=/; Secure
Set-Cookie: ds_user_id=31310607724; Domain=.instagram.com; expires=Wed, 16-Sep-2020 21:27:01 GMT; Max-Age=7776000; Path=/; Secure
Set-Cookie: sessionid=31310607724%3AfiJPnWxF4tyi5n%3A16; Domain=.instagram.com; expires=Fri, 18-Jun-2021 21:27:01 GMT; HttpOnly; Max-Age=31536000; Path=/; Secure
Date: Thu, 18 Jun 2020 21:27:01 GMT
X-FB-TRIP-ID: 1679558926
Connection: keep-alive
Content-Length: 87

"
}
*/