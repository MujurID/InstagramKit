<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramAuth;

$cookie = 'yourcookie';

$auth = new InstagramAuth();

$results = $auth->AuthUsingCookie($cookie);

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(5) {
  ["userid"]=>
  string(11) "31310607724"
  ["username"]=>
  string(8) "riedayme"
  ["photo"]=>
  string(275) "https://instagram.fcgk12-1.fna.fbcdn.net/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=instagram.fcgk12-1.fna.fbcdn.net&_nc_cat=1&_nc_ohc=ZMRBdU8i2AoAX8UFN5x&oh=a0e015a1a0933b2e7c84627e9374d000&oe=5F13AC8F&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2"
  ["cookie"]=>
  string(1256) "csrftoken=iSltAm3jRXF0jgmAK0QGbLKL51TOGzwO;ds_user_id=31310607724;fbm_124024574287414=base_domain=.instagram.com;fbsr_124024574287414=Ey01OaiVejNxqJAUJhhQiVAO78jBr3J17DuZ0vpgaJg.eyJ1c2VyX2lkIjoiMTAwMDE2ODY1NzAzMzc0IiwiY29kZSI6IkFRQkN5S2RNVmR2TE5GcjRQRi1GZTZ6bVd6dVZUVFg1RF9QVWp5LW5CVXdOUEFfT2toNXd2WXIybjN5WGFEUzd4RFRNZzFLT0hVNFRCR1ZMRWczdGlqR0NHbWZ1VVJpcHEyVTdQdWdvaTQ3ZUFEOU9JYnZKbEp3S0kyYUdCWGFLMEFNQWFtdWVzeEhmQUlCRm1yUEhYWEUxaFFWV1FJOUxxSE1DLWlUWXJVVXpsck5ZSmQ0QkVDSm41dVpOZFl2ZDJ2cDhLajFVTERKXzFkOU5YRXNoOWRESEpJRGliaC1WZndVbXNhTkRNRXpLUVZGZUtGQ1JwY2JiQks3OTZhWjRyNzRDaXFrS0pSQTBzSWVtZ3lVeXU4NER4d2E2dC1rQUhrQWR1QndiZ1ZhUTV5Q09XeWMzc0NtMFVPc0Q1ZmN4ZFhVYjU3eFA2WDBwUjUtVUtiaHgwMXNPIiwib2F1dGhfdG9rZW4iOiJFQUFCd3pMaXhuallCQUN0QzVLbWFGS2dEVWduMmtENGloc2xaQ2ZNTDFJN25IRVJiSDhUNHAwVXZZU25DWHU0emdMUkw4MzdxNVc0Z1huVThBaGFyN1BOMEQ0eWU0R1pBbjVycVI0M0JtU3kwaEQyTlAxMjRHNXpZWElHOHNPcUxNaEZqZ3o5Skt2R2l1WkJvU2tySWJCSVpDRzBsSVZRN2ljTk1MRWt5ck5wOU5raE9GOE8xIiwiYWxnb3JpdGhtIjoiSE1BQy1TSEEyNTYiLCJpc3N1ZWRfYXQiOjE1OTI0NzA3NzV9;ig_did=D0E2DBA9-2CEE-459D-B501-A3A1AC6A1553;mid=XulV_QAEAAFxBhSklSTSSy1C2dbV;rur=VLL;sessionid=31310607724%3AW2Mq8iMlFDWfdS%3A15;shbid=8056;shbts=1592470793.4282007;urlgen="{\"180.244.232.112\": 7713}:1jls7I:EZ6P0GjpOPhIlPXXFIEE2_EQmqw";"
  ["csrftoken"]=>
  string(32) "iSltAm3jRXF0jgmAK0QGbLKL51TOGzwO"
}
*/