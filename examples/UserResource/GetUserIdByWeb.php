<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramResourceUser;

$username = 'faanteyki';

$read = new InstagramResourceUser();

$userid = $read->GetUserIdByWeb($username);

echo "<pre>";
var_dump($userid);
echo "</pre>";