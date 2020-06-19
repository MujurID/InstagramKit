<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramPostReadAPI;

$datacookie = 'yourcookie';

$readpost = new InstagramPostReadAPI();
$readpost->SetCookie($datacookie);
$readpost->GetPost();

$results = $readpost->Read();

echo "<pre>";
var_dump($results);
echo "</pre>";

/*
array(1) {
  [0]=>
  array(5) {
    ["pk"]=>
    int(2332344911195799233)
    ["media_type"]=>
    int(2)
    ["code"]=>
    string(11) "CBeJ1blg_7B"
    ["caption"]=>
    string(77) "Kenapa Anak IT Gak Bisa Ngoding ? https://www.youtube.com/watch?v=-NlG8tFJ2mQ"
    ["photo"]=>
    array(3) {
      ["original"]=>
      string(286) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/104414629_304878833874653_5959884403730845525_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=105&_nc_ohc=I7HMYz9zum8AX-CnmnH&oh=0c04cc1a7660d611548673f1fbeb2146&oe=5F142F60&ig_cache_key=MjMzMjM0NDkxMTE5NTc5OTIzMw%3D%3D.2"
      ["small"]=>
      string(295) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/s360x360/104414629_304878833874653_5959884403730845525_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=105&_nc_ohc=I7HMYz9zum8AX-CnmnH&oh=d9bccf6b5f02158302081cbd6f9b13ca&oe=5F1569CE&ig_cache_key=MjMzMjM0NDkxMTE5NTc5OTIzMw%3D%3D.2"
      ["type"]=>
      string(5) "Video"
    }
  }
}
*/