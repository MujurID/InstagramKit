<?php  
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://www.instagram.com/direct_v2/web/create_group_thread/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'recipient_users=["9868652404"]');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Authority: www.instagram.com';
$headers[] = 'X-Ig-Www-Claim: hmac.AR2sQMxsgNFPzh-C8AImL3f8L68GuOzLVAEn7wXHAeEcnMhX';
$headers[] = 'X-Instagram-Ajax: 4f336da7de59';
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
$headers[] = 'Accept: */*';
$headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Mobile Safari/537.36';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'X-Csrftoken: k8CCs0jCOr4yqRwpylqfWy0D3yJKASMq';
$headers[] = 'X-Ig-App-Id: 1217981644879628';
$headers[] = 'Origin: https://www.instagram.com';
$headers[] = 'Sec-Fetch-Site: same-origin';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Referer: https://www.instagram.com/relaxing.media/';
$headers[] = 'Accept-Language: en-US,en;q=0.9,id;q=0.8';
$headers[] = 'Cookie: csrftoken=k8CCs0jCOr4yqRwpylqfWy0D3yJKASMq;ds_user_id=31310607724;fbm_124024574287414=base_domain=.instagram.com;ig_did=FFEACD10-63D8-43C2-B401-42ECE4037BE0;mid=Xlj5PgALAAGDe8LS6ehFhHVYc-jN;rur=VLL;sessionid=31310607724%3Ay2SJ6kcsSBEfgE%3A15;shbid=8056;shbts=1593258288.7545347;urlgen="{\"180.244.234.109\": 7713\054 \"180.244.234.247\": 7713}:1jpS5b:RmPyJZaJnjnpqlEf6h-Ju-fHcfA";';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
	echo 'Error:' . curl_error($ch);
}
curl_close($ch);

echo $result."<br/><br/>";

$time = time();

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://www.instagram.com/rupload_igphoto/direct_'.$time);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents('test.jpg'));

$headers = array();
$headers[] = 'Authority: www.instagram.com';
$headers[] = 'X-Ig-Www-Claim: hmac.AR2sQMxsgNFPzh-C8AImL3f8L68GuOzLVAEn7wXHAeEcnMhX';
$headers[] = 'Offset: 0';
$headers[] = 'X-Entity-Name: direct_'.$time;
$headers[] = 'X-Instagram-Ajax: 4f336da7de59';
$headers[] = 'Content-Type: image/jpeg';
$headers[] = 'Accept: */*';
$headers[] = 'X-Instagram-Rupload-Params: {"media_type":1,"upload_id":"'.$time.'","upload_media_height":627,"upload_media_width":1080}';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'X-Entity-Length: 114044';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36';
$headers[] = 'X-Csrftoken: k8CCs0jCOr4yqRwpylqfWy0D3yJKASMq';
$headers[] = 'X-Ig-App-Id: 936619743392459';
$headers[] = 'Origin: https://www.instagram.com';
$headers[] = 'Sec-Fetch-Site: same-origin';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Referer: https://www.instagram.com/direct/t/340282366841710300949128132822832201865';
$headers[] = 'Accept-Language: en-US,en;q=0.9,id;q=0.8';
$headers[] = 'Cookie: csrftoken=k8CCs0jCOr4yqRwpylqfWy0D3yJKASMq;ds_user_id=31310607724;fbm_124024574287414=base_domain=.instagram.com;ig_did=FFEACD10-63D8-43C2-B401-42ECE4037BE0;mid=Xlj5PgALAAGDe8LS6ehFhHVYc-jN;rur=VLL;sessionid=31310607724%3Ay2SJ6kcsSBEfgE%3A15;shbid=8056;shbts=1593258288.7545347;urlgen="{\"180.244.234.109\": 7713\054 \"180.244.234.247\": 7713}:1jpS5b:RmPyJZaJnjnpqlEf6h-Ju-fHcfA";';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
	echo 'Error:' . curl_error($ch);
}
curl_close($ch);

echo $result."<br/><br/>";

// {"upload_id": "1593331371065", "xsharing_nonces": {}, "status": "ok"}

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://www.instagram.com/direct_v2/web/threads/broadcast/configure_photo/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "action=send_item&allow_full_aspect_ratio=1&content_type=photo&mutation_token=1bd9876b-bf16-4fcf-a8e3-2518b0bc9c75&sampled=1&thread_id=340282366841710300949128132822832201865&upload_id=".$time);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Authority: www.instagram.com';
$headers[] = 'X-Ig-Www-Claim: hmac.AR2sQMxsgNFPzh-C8AImL3f8L68GuOzLVAEn7wXHAeEcnMhX';
$headers[] = 'X-Instagram-Ajax: 4f336da7de59';
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
$headers[] = 'Accept: */*';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'X-Csrftoken: k8CCs0jCOr4yqRwpylqfWy0D3yJKASMq';
$headers[] = 'X-Ig-App-Id: 936619743392459';
$headers[] = 'Origin: https://www.instagram.com';
$headers[] = 'Sec-Fetch-Site: same-origin';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Referer: https://www.instagram.com/direct/t/340282366841710300949128132822832201865';
$headers[] = 'Accept-Language: en-US,en;q=0.9,id;q=0.8';
$headers[] = 'Cookie: csrftoken=k8CCs0jCOr4yqRwpylqfWy0D3yJKASMq;ds_user_id=31310607724;fbm_124024574287414=base_domain=.instagram.com;ig_did=FFEACD10-63D8-43C2-B401-42ECE4037BE0;mid=Xlj5PgALAAGDe8LS6ehFhHVYc-jN;rur=VLL;sessionid=31310607724%3Ay2SJ6kcsSBEfgE%3A15;shbid=8056;shbts=1593258288.7545347;urlgen="{\"180.244.234.109\": 7713\054 \"180.244.234.247\": 7713}:1jpS5b:RmPyJZaJnjnpqlEf6h-Ju-fHcfA";';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
	echo 'Error:' . curl_error($ch);
}
curl_close($ch);

echo $result."<br/><br/>";

// {"action": "item_ack", "status_code": "200", "payload": {"client_context": null, "item_id": "29391776061677749893588429274349568", "timestamp": "1593331372963923", "thread_id": "340282366841710300949128132822832201865"}, "status": "ok"}