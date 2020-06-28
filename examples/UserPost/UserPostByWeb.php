<?php  
require "../../vendor/autoload.php";

use Riedayme\InstagramKit\InstagramUserPost;

$datacookie = 'yourcookie';

$userid = '3555900579';

$readpost = new InstagramUserPost();
$readpost->SetCookie($datacookie);

$cursor = false;
$all_data = array();
$count = 0;
$limit = 1;
do {
  
  $post = $readpost->Process($userid,$cursor);

  if (!$post['status']) {
    echo $post['response'];
    break;
  }
  
  $data = $readpost->Extract($post);

  $all_data = array_merge($all_data,$data);

  if ($post['cursor'] !== null) {
    $cursor = $post['cursor'];
  }else{
    $cursor = false;
  }

  $count = $count+1;
} while ($cursor !== false AND $count < $limit);


echo "<pre>";
var_dump($all_data);
echo "</pre>";

/*
array(12) {
  [0]=>
  array(8) {
    ["id"]=>
    string(19) "2334281408218311186"
    ["username"]=>
    string(8) "iayulstr"
    ["code"]=>
    string(11) "CBlCJK-pqoS"
    ["url"]=>
    string(40) "https://www.instagram.com/p/CBlCJK-pqoS/"
    ["type"]=>
    string(8) "carousel"
    ["media"]=>
    array(3) {
      [0]=>
      array(2) {
        ["media"]=>
        string(234) "https://scontent-sin6-1.cdninstagram.com/v/t50.2886-16/104339155_273746073742117_7033513501107473533_n.mp4?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=101&_nc_ohc=0oBmJOTb5wgAX8-R5Jj&oe=5EFA7838&oh=e10a40c4c7f12ee0387d048a8c25e0a6"
        ["type"]=>
        string(5) "video"
      }
      [1]=>
      array(2) {
        ["media"]=>
        string(238) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/104219959_308184296862375_9078975739818173827_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=103&_nc_ohc=d3-16g4LDl8AX-n-1yf&oh=7db89c86593858725132ebc2de91b55a&oe=5F22FF45"
        ["type"]=>
        string(5) "image"
      }
      [2]=>
      array(2) {
        ["media"]=>
        string(238) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/103977465_876938346145258_3144809334778514105_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=110&_nc_ohc=iVVhd3GEWIsAX_bz4uH&oh=f8167b79991f2f583f758eb230bad983&oe=5F20FAB0"
        ["type"]=>
        string(5) "image"
      }
    }
    ["caption"]=>
    string(199) "Maap emang edit nya di tiktok 🙂 (gasi sebenernya sampe 3 apk edit wkwk)
Mencoba ikutin #barbiechallenge ini,tapi keknya fail😆 
yaudah gpp lah buat seru-seruan😂

Inspired by : @jharnabhagwani"
    ["haslike"]=>
    bool(false)
  }
  [1]=>
  array(8) {
    ["id"]=>
    string(19) "2321236259831358017"
    ["username"]=>
    string(8) "iayulstr"
    ["code"]=>
    string(11) "CA2sBRzASJB"
    ["url"]=>
    string(40) "https://www.instagram.com/p/CA2sBRzASJB/"
    ["type"]=>
    string(5) "image"
    ["media"]=>
    string(239) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/101447689_2607042099583368_7051111474820357272_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=100&_nc_ohc=GO5_CPRzDdMAX8jK4zB&oh=0fdf0fe69edcd2becf7cf80cf139bf47&oe=5F1FC8EB"
    ["caption"]=>
    string(90) "Aloha (:
Ga,ini bukan gue bukaaannnnnnnnnn aaarggghhhh mengapa epek mengubah segalanya😭"
    ["haslike"]=>
    bool(false)
  }
  [2]=>
  array(8) {
    ["id"]=>
    string(19) "2310703836314433712"
    ["username"]=>
    string(8) "iayulstr"
    ["code"]=>
    string(11) "CARROWAp3iw"
    ["url"]=>
    string(40) "https://www.instagram.com/p/CARROWAp3iw/"
    ["type"]=>
    string(8) "carousel"
    ["media"]=>
    array(2) {
      [0]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/97285955_246080279941855_2826370016696718867_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=107&_nc_ohc=TzqEfYOO8_IAX8YGRnB&oh=d67f94ae9ef9f1d43323cc0a4ba7a28a&oe=5F1FC389"
        ["type"]=>
        string(5) "image"
      }
      [1]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/97359281_246068096836441_4467785185345308994_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=101&_nc_ohc=QwIsSoKBuUUAX9bciDh&oh=da708839dbb8782f4c7b28abc76f0611&oe=5F2321DF"
        ["type"]=>
        string(5) "image"
      }
    }
    ["caption"]=>
    string(53) "Gada bedanya cuma beda di filter😂

#pink 
#onfleek"
    ["haslike"]=>
    bool(false)
  }
  [3]=>
  array(8) {
    ["id"]=>
    string(19) "2299301130232388390"
    ["username"]=>
    string(8) "iayulstr"
    ["code"]=>
    string(11) "B_owjIbJ9sm"
    ["url"]=>
    string(40) "https://www.instagram.com/p/B_owjIbJ9sm/"
    ["type"]=>
    string(5) "video"
    ["media"]=>
    string(234) "https://scontent-sin6-1.cdninstagram.com/v/t50.2886-16/95163342_1186195018395931_6078882869667647937_n.mp4?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=107&_nc_ohc=mk1ebje63vwAX86tVVu&oe=5EFAC86F&oh=925b834e246f0e66d961df201df9b14a"
    ["caption"]=>
    string(315) "Udah lama mau bikin video kek gini,tapi baru sempet🙂 gapapa lah ya ga bagus² amat.. bodoamat deh alis gue deh terserah alisnya deh wkwk dan udah pake maskara juga ga keliatan bulu matanya naek,sebel🥺..
Btw,mon maap w pake mukena soalnya kerudungan gue yg ndemplek(?) dimuka lagi di cuci (: #makeuplook 
#solo"
    ["haslike"]=>
    bool(false)
  }
  [4]=>
  array(8) {
    ["id"]=>
    string(19) "2289880932869785654"
    ["username"]=>
    string(8) "iayulstr"
    ["code"]=>
    string(11) "B_HSpN9pMg2"
    ["url"]=>
    string(40) "https://www.instagram.com/p/B_HSpN9pMg2/"
    ["type"]=>
    string(5) "video"
    ["media"]=>
    string(233) "https://scontent-sin6-2.cdninstagram.com/v/t50.2886-16/93422818_664243017705533_1923806821175059054_n.mp4?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=105&_nc_ohc=Q0RCOuOrpO0AX-7m5kL&oe=5EFA69BC&oh=ebe0008156c167b95ca23ecdbb3bb6bb"
    ["caption"]=>
    string(106) "#passthebrushchallenge 
Lalalalala lonely~

In frame (@adheliapuspita, @deskaputrikurnia,@dwitifanyfadiat)"
    ["haslike"]=>
    bool(false)
  }
  [5]=>
  array(8) {
    ["id"]=>
    string(19) "2289161617583335087"
    ["username"]=>
    string(8) "iayulstr"
    ["code"]=>
    string(11) "B_EvFzZg2av"
    ["url"]=>
    string(40) "https://www.instagram.com/p/B_EvFzZg2av/"
    ["type"]=>
    string(8) "carousel"
    ["media"]=>
    array(5) {
      [0]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/93491909_159280612237517_6984730623236006180_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=105&_nc_ohc=n_ZxUB6WUWcAX83naDi&oh=44630a3920caddd1165ee83ea2e920f2&oe=5F22D11D"
        ["type"]=>
        string(5) "image"
      }
      [1]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/92926914_128793892059657_2904196917482822870_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=109&_nc_ohc=9F27bXg-HfkAX_S0lvg&oh=32c6d04baad86f47e971bbe2514cac3c&oe=5F210F9E"
        ["type"]=>
        string(5) "image"
      }
      [2]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/93458428_148123423394886_3216018051500382401_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=106&_nc_ohc=J59adfgbtFcAX-zXceA&oh=2186bbc43a493e909dac0d8aa560d34e&oe=5F20F7C9"
        ["type"]=>
        string(5) "image"
      }
      [3]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/93359070_718568792220525_8248646195664670680_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=109&_nc_ohc=3se0d1_kXKEAX_ezepZ&oh=0bfcf16ec5bcd973526cd7fc814b084f&oe=5F1FF26D"
        ["type"]=>
        string(5) "image"
      }
      [4]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/93223738_531976347357490_4047307059312061664_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=110&_nc_ohc=sRHSCDPgK-0AX8pkYm1&oh=e93302b59ed96ed35fed572c72115c8c&oe=5F1FBD44"
        ["type"]=>
        string(5) "image"
      }
    }
    ["caption"]=>
    string(216) "Feel like Jang man wol😆
Btw,karna kusuka sekali warna biru jadi kupakai black pink😂
Slide ke-3 napa tegang amat ya😭🤣 Oiya,dress cantik ini ku beli di @dexalove_ dan sendalnya pun di @dexalove.stuff ☺️"
    ["haslike"]=>
    bool(false)
  }
  [6]=>
  array(8) {
    ["id"]=>
    string(19) "2255113974668748019"
    ["username"]=>
    string(8) "iayulstr"
    ["code"]=>
    string(11) "B9LxjY8JmTz"
    ["url"]=>
    string(40) "https://www.instagram.com/p/B9LxjY8JmTz/"
    ["type"]=>
    string(8) "carousel"
    ["media"]=>
    array(6) {
      [0]=>
      array(2) {
        ["media"]=>
        string(238) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/83773348_2623427234452424_6082701285481803298_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=108&_nc_ohc=rdlOl2X-8soAX9mk1Yq&oh=4ec93ab54b6fc4c021bb3157138db7a6&oe=5F2381D0"
        ["type"]=>
        string(5) "image"
      }
      [1]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/84331784_497670077607576_1303093417882606108_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=100&_nc_ohc=P28UUe_2GJQAX9k0zmo&oh=7eae4a66cc2debe3e1ffad828ec0cc4e&oe=5F214EE4"
        ["type"]=>
        string(5) "image"
      }
      [2]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/88183159_141028737392512_6224917755102469483_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=104&_nc_ohc=38u_xF2-oTgAX-ZaQBe&oh=7b6124c0f5842924c89e09e6c23a96c1&oe=5F214F44"
        ["type"]=>
        string(5) "image"
      }
      [3]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/87556213_510883673165182_3877982452694222910_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=110&_nc_ohc=fWJsGepA4cgAX8ZYolW&oh=6cb0465f6e966d6df1c2a77c0095cc2d&oe=5F2077D2"
        ["type"]=>
        string(5) "image"
      }
      [4]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/87637748_221857472196258_7621615577955353500_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=106&_nc_ohc=64m1KObvQxMAX9OQV_E&oh=39f93e9f0e70e6ebf650a5c02de353c5&oe=5F234F49"
        ["type"]=>
        string(5) "image"
      }
      [5]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/87653004_195477291862730_1404499157205643176_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=102&_nc_ohc=kexHq00cPDsAX_HpOZL&oh=d7bf1c33e98f89f1de9335d257dc6662&oe=5F2209E7"
        ["type"]=>
        string(5) "image"
      }
    }
    ["caption"]=>
    bool(false)
    ["haslike"]=>
    bool(false)
  }
  [7]=>
  array(8) {
    ["id"]=>
    string(19) "2211666539248185217"
    ["username"]=>
    string(8) "iayulstr"
    ["code"]=>
    string(11) "B6xav_hgW-B"
    ["url"]=>
    string(40) "https://www.instagram.com/p/B6xav_hgW-B/"
    ["type"]=>
    string(8) "carousel"
    ["media"]=>
    array(10) {
      [0]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/81298969_1803675543096012_482604749001237293_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=100&_nc_ohc=7XeFpjc-Wv8AX-zffx-&oh=8cc3fa4f50cb6e6f9d009ae01f89b22d&oe=5F238E79"
        ["type"]=>
        string(5) "image"
      }
      [1]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/80584749_115840523011956_5459364412002286881_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=100&_nc_ohc=zbgH9WNQsM8AX8V001g&oh=ce15e3bbd33a188d344f6975ec83bddc&oe=5F1FC725"
        ["type"]=>
        string(5) "image"
      }
      [2]=>
      array(2) {
        ["media"]=>
        string(236) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/79376596_110992190255001_893434570166957309_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=109&_nc_ohc=p8vyUsxBkMUAX_X1CHV&oh=b1e763d8b9de7505608a2b6ff7f1ac07&oe=5F22A56E"
        ["type"]=>
        string(5) "image"
      }
      [3]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/79250162_164924198194922_8021875647449099300_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=102&_nc_ohc=zR_C_KH4KL4AX9CVQaB&oh=3c0f4a6d038d69043d459904ed77b4cb&oe=5F23A6F0"
        ["type"]=>
        string(5) "image"
      }
      [4]=>
      array(2) {
        ["media"]=>
        string(238) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/79529234_1004897503227822_8796232493322391880_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=106&_nc_ohc=hzSpcbo8UxIAX-DQJDF&oh=a338b3a95b3c519de770cf8be626598b&oe=5F224583"
        ["type"]=>
        string(5) "image"
      }
      [5]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/79601208_226755108337297_5223359376553283361_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=101&_nc_ohc=8rX_a32RgbMAX_oU-O5&oh=6876236eda5df6f022272efd0f3aa417&oe=5F23000D"
        ["type"]=>
        string(5) "image"
      }
      [6]=>
      array(2) {
        ["media"]=>
        string(238) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/79461347_2498670376869028_1587757089947774750_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=104&_nc_ohc=BafUGVrLKcwAX_mdJHH&oh=3780eb58e678da52c942d51230f025db&oe=5F21E0EC"
        ["type"]=>
        string(5) "image"
      }
      [7]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/81751435_452336132322969_1586761964076379645_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=109&_nc_ohc=ySEP4sLNQkIAX_w4qg2&oh=10419aa9ccb82fe144b2977eccd825b9&oe=5F2284AF"
        ["type"]=>
        string(5) "image"
      }
      [8]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/81467573_545215996063315_1098266249886642476_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=107&_nc_ohc=fGxx44g0WFcAX9UUkql&oh=f6fa3b1acfa59ec379f3bc80f3e36636&oe=5F2098C7"
        ["type"]=>
        string(5) "image"
      }
      [9]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/79032451_196100151438866_8347771614196209451_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=102&_nc_ohc=BI0FCKr4mAgAX96Laoy&oh=8a5d500951e9f3c86d097cd4299be81a&oe=5F2235E6"
        ["type"]=>
        string(5) "image"
      }
    }
    ["caption"]=>
    string(126) "#2020 
Yaudah cuma hesteg doang , mang napasi gaboleh?!🤪 .
.
.
.
.
.
In frame : @dsimlni , @sevivera_11 .
.
.
.
📸 : thor"
    ["haslike"]=>
    bool(false)
  }
  [8]=>
  array(8) {
    ["id"]=>
    string(19) "2209601730988449501"
    ["username"]=>
    string(8) "iayulstr"
    ["code"]=>
    string(11) "B6qFRE-p57d"
    ["url"]=>
    string(40) "https://www.instagram.com/p/B6qFRE-p57d/"
    ["type"]=>
    string(8) "carousel"
    ["media"]=>
    array(5) {
      [0]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/79506443_171393747282455_7183867246753777840_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=111&_nc_ohc=6vTbUNio2UQAX-W2XLa&oh=146dc9678180f997d157a5200b0cfa76&oe=5F2181DD"
        ["type"]=>
        string(5) "image"
      }
      [1]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/79176199_301874684060181_1644888514681286251_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=109&_nc_ohc=3QiqDtV5N-IAX9tQ1lS&oh=4dcdee1835c914f6c86fa1bda7c49939&oe=5F2374C2"
        ["type"]=>
        string(5) "image"
      }
      [2]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/79377114_512122392986018_3874013685866938402_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=102&_nc_ohc=_s9_Aw47PToAX9CHEmx&oh=ced2ac6ca963099de1d85c0d4a72b5a9&oe=5F20D583"
        ["type"]=>
        string(5) "image"
      }
      [3]=>
      array(2) {
        ["media"]=>
        string(238) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/81477345_1348916751954846_6162325755420000704_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=106&_nc_ohc=wgwxt1jwxoUAX_LiWOj&oh=2baad5255cd3cd6eb7e34dbf7a16def7&oe=5F22831B"
        ["type"]=>
        string(5) "image"
      }
      [4]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/76993872_489948504990485_7722871281529488312_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=105&_nc_ohc=smtxelgzB08AX-zG14i&oh=0e8d0e58328ecda6202e6a3546e9ab6f&oe=5F22256D"
        ["type"]=>
        string(5) "image"
      }
    }
    ["caption"]=>
    string(162) "Wedding day nya mba kuh @auliaiza77,wedding ini mempertemukanku kepada mereka yg sekian lama tidak bertemu wkwk @sevivera_11 dan @dsimlni 
#wedding 
#sundayfunday"
    ["haslike"]=>
    bool(false)
  }
  [9]=>
  array(8) {
    ["id"]=>
    string(19) "2202397289402924703"
    ["username"]=>
    string(8) "iayulstr"
    ["code"]=>
    string(11) "B6QfKp5JP6f"
    ["url"]=>
    string(40) "https://www.instagram.com/p/B6QfKp5JP6f/"
    ["type"]=>
    string(8) "carousel"
    ["media"]=>
    array(4) {
      [0]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/78856792_115851916571853_8865372151554277844_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=109&_nc_ohc=Tf87SlCIsYcAX-uGjBE&oh=e8b3721825e578e5a9a884754f58a4d6&oe=5F230A4A"
        ["type"]=>
        string(5) "image"
      }
      [1]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/75566987_104433227662317_2923980813579546019_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=109&_nc_ohc=I33ne-XFjy4AX_jyRBn&oh=41891833b505b49cee8b19f04af0f73c&oe=5F20AE70"
        ["type"]=>
        string(5) "image"
      }
      [2]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/80788230_192846335180994_5388735902830398168_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=106&_nc_ohc=1vPRXQPYTwQAX-oTpNh&oh=00d7107b4c205f4cf33c1a608d7c4f9c&oe=5F20BCDF"
        ["type"]=>
        string(5) "image"
      }
      [3]=>
      array(2) {
        ["media"]=>
        string(583) "https://scontent-sin6-2.cdninstagram.com/v/t50.2886-16/81437358_576604326244707_6275297944003130923_n.mp4?efg=eyJ2ZW5jb2RlX3RhZyI6InZ0c192b2RfdXJsZ2VuLjcyMC5jYXJvdXNlbF9pdGVtLmRlZmF1bHQiLCJxZV9ncm91cHMiOiJbXCJpZ193ZWJfZGVsaXZlcnlfdnRzX290ZlwiXSJ9&_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=103&_nc_ohc=8BgvZLucXi4AX9RA-NO&vs=17857631407658665_1173270012&_nc_vs=HBkcFQAYJEdLNmkyZ1Jqc1Fvb2F3d0NBQ3UyQzJ3N1ZoWlhia1lMQUFBRhUAAsgBACgAGAAbABUAABgAFtKWgOf52rg%2FFQIoAkMzLBdAFxBiTdLxqhgSZGFzaF9iYXNlbGluZV8xX3YxEQB17gcA&_nc_rid=c6c4328457&oe=5EFA79EF&oh=0fd76b539967f93e380389e83e96ec86"
        ["type"]=>
        string(5) "video"
      }
    }
    ["caption"]=>
    string(48) "Idk but,gue pen posting😛
Btw. Hello December!"
    ["haslike"]=>
    bool(false)
  }
  [10]=>
  array(8) {
    ["id"]=>
    string(19) "2178402656654368225"
    ["username"]=>
    string(8) "iayulstr"
    ["code"]=>
    string(11) "B47Payvpp3h"
    ["url"]=>
    string(40) "https://www.instagram.com/p/B47Payvpp3h/"
    ["type"]=>
    string(8) "carousel"
    ["media"]=>
    array(6) {
      [0]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/72529236_427882624567655_2314099279463810660_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=111&_nc_ohc=vVjCx3TQ8ksAX_-um5M&oh=9cee4bd6e5bce32a8212213db38c643e&oe=5F234CBD"
        ["type"]=>
        string(5) "image"
      }
      [1]=>
      array(2) {
        ["media"]=>
        string(238) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/74645231_2540717462869543_7427459565741593643_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=107&_nc_ohc=md8Uwamo7icAX8ljY6G&oh=5a03da083b161d4df4026bae64466a37&oe=5F212C20"
        ["type"]=>
        string(5) "image"
      }
      [2]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/73200499_203301900679577_8925092727866033200_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=105&_nc_ohc=z1zszgNxcuwAX9hAr0D&oh=3fcc4d0cb84e9825790dac671c908560&oe=5F20C4BE"
        ["type"]=>
        string(5) "image"
      }
      [3]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/72923822_2793614617323374_341095754777899705_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=102&_nc_ohc=aAxZBCGGF48AX8KifYc&oh=f9c702e69851cc54c0408033bd23c823&oe=5F1FE20B"
        ["type"]=>
        string(5) "image"
      }
      [4]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/73123796_182981362875240_6822344968072355952_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=100&_nc_ohc=iZKYtE6gGTMAX-IkLFs&oh=2a1f3074bdc800eee17f5f4b48fd01ae&oe=5F201A16"
        ["type"]=>
        string(5) "image"
      }
      [5]=>
      array(2) {
        ["media"]=>
        string(236) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/74605124_181936822989333_138434979399517090_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=109&_nc_ohc=S-TSA3TSgr8AX-Gj8tE&oh=9b679040720b0cf8f804e64ef0d460b9&oe=5F2111C4"
        ["type"]=>
        string(5) "image"
      }
    }
    ["caption"]=>
    string(149) "Gatau males mikir caption.

In frame (@anandasi04 , @deskaputrikurnia )

#saturday #happy #work #luck #life #love #krlindonesia #brandambassador 😂"
    ["haslike"]=>
    bool(false)
  }
  [11]=>
  array(8) {
    ["id"]=>
    string(19) "2173464108842893577"
    ["username"]=>
    string(8) "iayulstr"
    ["code"]=>
    string(11) "B4pshdrpEEJ"
    ["url"]=>
    string(40) "https://www.instagram.com/p/B4pshdrpEEJ/"
    ["type"]=>
    string(8) "carousel"
    ["media"]=>
    array(10) {
      [0]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/72473414_180828556379827_2290416365977123631_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=107&_nc_ohc=RTfisvLPs6oAX82Kzah&oh=8ce1e347992a9f3a83c558a483760e99&oe=5F2009F3"
        ["type"]=>
        string(5) "image"
      }
      [1]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/72527399_523365661851818_1239740059840621046_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=102&_nc_ohc=-7H4-zd3h3cAX_QA2m9&oh=cf2582c880767319cc681defb7a4039d&oe=5F214267"
        ["type"]=>
        string(5) "image"
      }
      [2]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/74694914_563218597828521_7813050111102097475_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=109&_nc_ohc=ZDbKIJiVGuUAX94FOMH&oh=ab3ea15d81efa132323d0151d2a0898d&oe=5F23A61D"
        ["type"]=>
        string(5) "image"
      }
      [3]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-1.cdninstagram.com/v/t51.2885-15/e35/73455942_224173368573312_8507414142878766049_n.jpg?_nc_ht=scontent-sin6-1.cdninstagram.com&_nc_cat=100&_nc_ohc=E7C0dA3D9nAAX-J7rLR&oh=d583099f27b89bc677fe1efa9175ae16&oe=5F20B1A4"
        ["type"]=>
        string(5) "image"
      }
      [4]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/74886242_174369257043485_3144895454589314593_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=105&_nc_ohc=G1PHFAsTQX8AX9sOEgB&oh=56367d5fc5336569a6d3fe2e9f71bf99&oe=5F201DC0"
        ["type"]=>
        string(5) "image"
      }
      [5]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/73456027_537677910350930_4373859275778991017_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=102&_nc_ohc=AG4w66yS8f8AX_dnWhg&oh=452320d5e046abe3480e7366cb977a26&oe=5F229814"
        ["type"]=>
        string(5) "image"
      }
      [6]=>
      array(2) {
        ["media"]=>
        string(236) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/72612532_484353205510421_764910129316706977_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=105&_nc_ohc=WYOlaWpa3eEAX8ORQaz&oh=afcfb0f2de2beef37281a90ed5e97dcc&oe=5F21D2B3"
        ["type"]=>
        string(5) "image"
      }
      [7]=>
      array(2) {
        ["media"]=>
        string(238) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/71219237_1679168852213757_3382021427044937984_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=109&_nc_ohc=LiXa-IONQMQAX_rLV4g&oh=73a11574a68f1de39f34c19a13753e7b&oe=5F20E65C"
        ["type"]=>
        string(5) "image"
      }
      [8]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/72103564_731466764024853_3094502781380019428_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=109&_nc_ohc=YCvnOeh_SPsAX8Z9MV3&oh=3c8a00722a8c979a006b095708f741ed&oe=5F21D6AE"
        ["type"]=>
        string(5) "image"
      }
      [9]=>
      array(2) {
        ["media"]=>
        string(237) "https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/73153519_493751461227801_4355524799743987223_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=109&_nc_ohc=n9hlts2waNsAX9OIl11&oh=39ebea530c5ef09576b1dcf46c9322db&oe=5F2355B3"
        ["type"]=>
        string(5) "image"
      }
    }
    ["caption"]=>
    string(267) "Mendaki gunung turuni lembah~ 
In frame (@kaa_widyana, @intannuryuniar,@radhenfahmi_,@hargiyanto.wahyu,Toriq)

#travelling #holiday #happy #luck #love #life #rawagede #WTFfamily #relationships #saturday #senja #celenganrindu #goldenhour (Maap,updatenya kecepetan😂)"
    ["haslike"]=>
    bool(false)
  }
}
*/