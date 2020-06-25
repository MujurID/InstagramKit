<?php  
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://www.instagram.com/graphql/query/?query_hash=c76146de99bb02f6415203be841dd25a&variables=%7B%22id%22%3A%227673389999%22%2C%22include_reel%22%3Atrue%2C%22fetch_mutual%22%3Atrue%2C%22first%22%3A24%7D');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Authority: www.instagram.com';
$headers[] = 'Cache-Control: no-cache';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36';
$headers[] = 'Accept: image/webp,image/apng,image/*,*/*;q=0.8';
$headers[] = 'Sec-Fetch-Site: same-origin';
$headers[] = 'Sec-Fetch-Mode: no-cors';
$headers[] = 'Sec-Fetch-User: ?1';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Accept-Language: en-US,en;q=0.9,id;q=0.8';
$headers[] = 'Cookie: csrftoken=k8CCs0jCOr4yqRwpylqfWy0D3yJKASMq;ds_user_id=31310607724;fbm_124024574287414=base_domain=.instagram.com;ig_did=FFEACD10-63D8-43C2-B401-42ECE4037BE0;mid=Xlj5PgALAAGDe8LS6ehFhHVYc-jN;rur=VLL;sessionid=31310607724%3Ay2SJ6kcsSBEfgE%3A15;shbid=8056;shbts=1592989138.5202322;urlgen="{\"180.242.152.195\": 7713}:1joK9B:z-uQOJ_BPTD_M4paG25c_zzFsCM";';
$headers[] = 'Pragma: no-cache';
$headers[] = 'Referer: https://www.instagram.com/graphql/query/?query_hash=c76146de99bb02f6415203be841dd25a^&variables=^%^7B^%^22id^%^22^%^3A^%^227673389999^%^22^%^2C^%^22include_reel^%^22^%^3Atrue^%^2C^%^22fetch_mutual^%^22^%^3Atrue^%^2C^%^22first^%^22^%^3A24^%^7D';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

echo $result;